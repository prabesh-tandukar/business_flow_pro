<?php
// =====================================================
// 2. Alternative Simple RoleSeeder (if above fails)
// Save this as RoleSeeder_Simple.php for testing
// =====================================================

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder_Simple extends Seeder
{
    public function run(): void
    {
        // Clear cache first
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Just create roles without permissions for now
        Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'manager',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'staff',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'customer',
            'guard_name' => 'web'
        ]);

        $this->command->info('✅ Simple roles seeded successfully');
    }
}
