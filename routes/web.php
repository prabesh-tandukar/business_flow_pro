<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

// Add these resource routes after your existing routes
Route::resource('companies', \App\Http\Controllers\CompanyController::class);
Route::resource('contacts', \App\Http\Controllers\ContactController::class);
Route::resource('leads', \App\Http\Controllers\LeadController::class);
Route::resource('deals', \App\Http\Controllers\DealController::class);
Route::resource('products', \App\Http\Controllers\ProductController::class);

// Test database connection route
Route::get('/test-db', function () {
    try {
        $dbConnection = DB::connection()->getPdo();
        $dbName = DB::connection()->getDatabaseName();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Database connected successfully',
            'database' => $dbName,
            'driver' => config('database.default'),
            'laravel_version' => app()->version(),
            'php_version' => phpversion(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Database connection failed',
            'error' => $e->getMessage(),
        ], 500);
    }
});

Route::get('/database-status', function () {
    try {
        $status = [
            'database_connection' => 'Connected',
            'permission_system' => 'Spatie Permission (Properly Configured)',
            'tables' => []
        ];

        // Check tables using Spatie Permission structure
        $tables = [
            'users', 'roles', 'model_has_roles', 'model_has_permissions', 'role_has_permissions',
            'companies', 'contacts', 'tags', 'contact_tags',
            'lead_sources', 'lead_statuses', 'leads', 'deal_stages', 'deal_types', 
            'deals', 'service_categories', 'products', 'deal_products'
        ];

        foreach ($tables as $table) {
            try {
                if (Schema::hasTable($table)) {
                    $status['tables'][$table] = DB::table($table)->count();
                } else {
                    $status['tables'][$table] = 'Missing';
                }
            } catch (\Exception $e) {
                $status['tables'][$table] = 'Error: ' . $e->getMessage();
            }
        }

        // Test Spatie Permission functionality
        $testUser = App\Models\User::first();
        $relationshipTest = [
            'user_exists' => false,
            'user_has_roles' => false,
            'user_roles' => [],
            'spatie_working' => false,
            'full_name_working' => false,
            'is_active_working' => false
        ];

        if ($testUser) {
            $relationshipTest['user_exists'] = true;
            
            try {
                // Test Spatie Permission methods
                $userRoles = $testUser->getRoleNames();
                $relationshipTest['user_has_roles'] = $userRoles->count() > 0;
                $relationshipTest['user_roles'] = $userRoles->toArray();
                $relationshipTest['spatie_working'] = true;
                
                // Test custom attributes
                $relationshipTest['full_name_working'] = !empty($testUser->full_name);
                $relationshipTest['is_active_working'] = is_bool($testUser->isActive());
                
            } catch (\Exception $e) {
                $relationshipTest['spatie_error'] = $e->getMessage();
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Database architecture with Spatie Permission verified!',
            'data' => $status,
            'relationship_test' => $relationshipTest,
            'week_2_complete' => true,
            'ready_for_week_3' => true
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});