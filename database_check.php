<?php
// database_check.php - Save and run: php database_check.php

echo "🔍 DATABASE DIAGNOSTIC\n";
echo "=====================\n\n";

// Check database connection
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=business_flow_pro',
        'root', 
        '', 
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "✅ Database connection successful\n\n";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Get all tables
$stmt = $pdo->query("SHOW TABLES");
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo "📋 EXISTING TABLES:\n";
echo "==================\n";
foreach ($tables as $table) {
    echo "- $table\n";
}

echo "\n🎯 SPATIE PERMISSION TABLES CHECK:\n";
echo "==================================\n";

$spatieTables = [
    'roles',
    'permissions', 
    'model_has_roles',
    'model_has_permissions',
    'role_has_permissions'
];

$missingTables = [];
foreach ($spatieTable as $table) {
    if (in_array($table, $tables)) {
        echo "✅ $table - EXISTS\n";
    } else {
        echo "❌ $table - MISSING\n";
        $missingTables[] = $table;
    }
}

echo "\n🔍 PROBLEM ANALYSIS:\n";
echo "====================\n";

if (!empty($missingTables)) {
    echo "❌ Missing Spatie tables: " . implode(', ', $missingTables) . "\n";
    echo "💡 Solution: Run Spatie migrations\n\n";
} else {
    echo "✅ All Spatie tables exist\n";
    echo "💡 Problem might be in configuration or model setup\n\n";
}

// Check if user_roles table exists (this shouldn't exist for Spatie)
if (in_array('user_roles', $tables)) {
    echo "⚠️  WARNING: 'user_roles' table exists - this conflicts with Spatie Permission\n";
    echo "💡 Solution: Remove user_roles table or fix configuration\n\n";
}

// Check users table structure
if (in_array('users', $tables)) {
    echo "👤 USERS TABLE STRUCTURE:\n";
    echo "=========================\n";
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
        echo "- {$column['Field']} ({$column['Type']})\n";
    }
    echo "\n";
}

// Check if there are any users
if (in_array('users', $tables)) {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $userCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "👥 Total users in database: $userCount\n\n";
    
    if ($userCount > 0) {
        $stmt = $pdo->query("SELECT id, email, first_name, last_name FROM users LIMIT 3");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "📋 Sample users:\n";
        foreach ($users as $user) {
            echo "- {$user['email']} ({$user['first_name']} {$user['last_name']})\n";
        }
        echo "\n";
    }
}

echo "🎯 NEXT STEPS:\n";
echo "==============\n";

if (!empty($missingTables)) {
    echo "1. Run: php artisan migrate\n";
    echo "2. Check: php artisan migrate:status\n";
    echo "3. If needed: php artisan migrate:fresh --seed\n";
} else {
    echo "1. Check Laravel migration status\n";
    echo "2. Verify Spatie configuration\n";
    echo "3. Test with simplified code\n";
}

echo "\n";
?>