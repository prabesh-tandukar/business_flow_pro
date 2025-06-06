<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login user and create token with rate limiting
     */
    public function login(Request $request): JsonResponse
    {
        // Rate limiting
        $key = 'login-attempts:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => ["Too many login attempts. Please try again in {$seconds} seconds."],
            ]);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'device_name' => 'nullable|string|max:255'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            RateLimiter::hit($key, 300); // 5 minutes
            
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Account is deactivated. Please contact your administrator.',
                'error_code' => 'ACCOUNT_DEACTIVATED'
            ], 403);
        }

        // Clear rate limiting on successful login
        RateLimiter::clear($key);

        // Update last login
        $user->update(['last_login_at' => now()]);

        // Create token with user's permissions
        $token = $user->createApiToken(
            $request->device_name ?? 'CRM API Token'
        );

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => $this->getUserData($user),
                'token' => $token->plainTextToken,
                'token_type' => 'Bearer',
                'expires_in' => config('sanctum.expiration', 525600) * 60,
                'crm_stats' => $user->getCrmStats(),
            ]
        ]);
    }

    /**
     * Get authenticated user with CRM data
     */
    public function user(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $this->getUserData($user),
                'crm_stats' => $user->getCrmStats(),
                'current_token' => [
                    'name' => $user->currentAccessToken()->name,
                    'abilities' => $user->currentAccessToken()->abilities,
                    'last_used_at' => $user->currentAccessToken()->last_used_at,
                ],
            ]
        ]);
    }

    /**
     * Logout user (revoke current token)
     */
    public function logout(Request $request): JsonResponse
    {
        $tokenName = $request->user()->currentAccessToken()->name;
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful',
            'revoked_token' => $tokenName
        ]);
    }

    /**
     * Logout from all devices (revoke all tokens)
     */
    public function logoutAll(Request $request): JsonResponse
    {
        $tokenCount = $request->user()->tokens()->count();
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out from all devices successfully',
            'revoked_tokens_count' => $tokenCount
        ]);
    }

    /**
     * Refresh token (create new token and revoke current)
     */
    public function refresh(Request $request): JsonResponse
    {
        $user = $request->user();
        $currentToken = $user->currentAccessToken();
        
        // Create new token with same abilities
        $newToken = $user->createApiToken(
            $currentToken->name ?? 'CRM API Token'
        );
        
        // Revoke current token
        $currentToken->delete();

        return response()->json([
            'success' => true,
            'message' => 'Token refreshed successfully',
            'data' => [
                'token' => $newToken->plainTextToken,
                'token_type' => 'Bearer',
                'expires_in' => config('sanctum.expiration', 525600) * 60,
            ]
        ]);
    }

    /**
     * Get user's active tokens
     */
    public function tokens(Request $request): JsonResponse
    {
        $currentTokenId = $request->user()->currentAccessToken()->id;
        $tokens = $request->user()->tokens()->get([
            'id', 'name', 'abilities', 'last_used_at', 'created_at'
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'tokens' => $tokens->map(function ($token) use ($currentTokenId) {
                    return [
                        'id' => $token->id,
                        'name' => $token->name,
                        'abilities' => $token->abilities,
                        'last_used_at' => $token->last_used_at,
                        'created_at' => $token->created_at,
                        'is_current' => $token->id === $currentTokenId,
                    ];
                }),
                'total_tokens' => $tokens->count(),
            ]
        ]);
    }

    /**
     * Revoke specific token
     */
    public function revokeToken(Request $request): JsonResponse
    {
        $request->validate([
            'token_id' => 'required|integer|exists:personal_access_tokens,id'
        ]);

        $token = $request->user()->tokens()->find($request->token_id);

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token not found or does not belong to you'
            ], 404);
        }

        if ($token->id === $request->user()->currentAccessToken()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot revoke current token. Use logout instead.'
            ], 400);
        }

        $tokenName = $token->name;
        $token->delete();

        return response()->json([
            'success' => true,
            'message' => 'Token revoked successfully',
            'revoked_token' => $tokenName
        ]);
    }

    /**
     * Get formatted user data
     */
    private function getUserData(User $user): array
    {
        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'full_name' => $user->full_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'position' => $user->position,
            'department' => $user->department,
            'timezone' => $user->timezone,
            'is_active' => $user->is_active,
            'last_login_at' => $user->last_login_at,
            'email_verified_at' => $user->email_verified_at,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'created_at' => $user->created_at,
        ];
    }
}