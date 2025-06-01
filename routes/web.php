<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

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

Route::get('/database-status', function(){
    try{
        $status = [
            'database_connection' => 'Connected',
            'tables' => [
                'user' => DB::table('users')->count(),
                'roles' => DB::table('roles')->count(),
                'companies' => DB::table('companies')->count(),
                'contacts' => DB::table('contacts')->cocunt(),
                'tags' => DB::table('tags')->count(),
                'lead_sources' => DB::table('lead_sources')->count(),
                'lead_statuses' => DB::table('lead_statuses')->count(),
                'leads' => DB::table('leads')->count(),
                'deal_stages' => DB::table('deal_stages')->count(),
                'deal_types' => DB::table('deal_types')->count(),
                'deals' => DB::table('deals')->count(),
                'service_categories' => DB::table('service_categories')->count(),
                'products' => DB::table('products')->count(),
                'deal_products' => DB::table('deal_products')->count(),
            ]
            ];
            return response()->json([
                'status' => 'success',
                'message' => 'Database architecture complete!',
                'data' => $status,
                'week_2_complete' => true
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

    });
