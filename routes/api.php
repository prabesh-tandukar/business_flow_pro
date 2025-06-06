<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API version prefix
Route::prefix('v1')->group(function () {
    
    // Public authentication routes
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login'])
            ->middleware('throttle:5,1'); // 5 attempts per minute
    });

    // Protected routes (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        
        // Authentication management
        Route::prefix('auth')->group(function () {
            Route::get('/user', [AuthController::class, 'user']);
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/logout-all', [AuthController::class, 'logoutAll']);
            Route::post('/refresh', [AuthController::class, 'refresh']);
            Route::get('/tokens', [AuthController::class, 'tokens']);
            Route::delete('/tokens', [AuthController::class, 'revokeToken']);
        });

        // API health check with user info
        Route::get('/health', function (Request $request) {
            return response()->json([
                'success' => true,
                'message' => 'CRM API is operational',
                'data' => [
                    'user' => $request->user()->full_name,
                    'user_role' => $request->user()->getRoleNames()->first(),
                    'timestamp' => now(),
                    'version' => '1.0.0',
                ]
            ]);
        });
    });

    // Temporary simple login without Spatie
Route::post('/auth/simple-login', function(Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user || !\Hash::check($request->password, $user->password)) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('Simple API Token');

    return response()->json([
        'success' => true,
        'user' => [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->first_name . ' ' . $user->last_name,
        ],
        'token' => $token->plainTextToken
    ]);
});
});


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
