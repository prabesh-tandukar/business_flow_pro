<?php

// =====================================================
// EXACT SPATIE PERMISSION SEEDERS
// =====================================================

// =====================================================
// 1. RoleSeeder.php (Simplified and Exact)
// database/seeders/RoleSeeder.php
// =====================================================

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cache first
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User management
            'users.create', 'users.read', 'users.update', 'users.delete',
            
            // Company management
            'companies.create', 'companies.read', 'companies.update', 'companies.delete',
            
            // Contact management
            'contacts.create', 'contacts.read', 'contacts.update', 'contacts.delete',
            
            // Lead management
            'leads.create', 'leads.read', 'leads.update', 'leads.delete',
            
            // Deal management
            'deals.create', 'deals.read', 'deals.update', 'deals.delete',
            
            // Job management
            'jobs.create', 'jobs.read', 'jobs.update', 'jobs.delete', 'jobs.assign',
            
            // Task management
            'tasks.create', 'tasks.read', 'tasks.update', 'tasks.delete', 'tasks.assign',
            
            // Time tracking
            'time.create', 'time.read', 'time.update', 'time.delete', 'time.approve',
            
            // Expense management
            'expenses.create', 'expenses.read', 'expenses.update', 'expenses.delete', 'expenses.approve',
            
            // Invoice management
            'invoices.create', 'invoices.read', 'invoices.update', 'invoices.delete',
            
            // Payment management
            'payments.create', 'payments.read', 'payments.update', 'payments.delete',
            
            // Reports
            'reports.view', 'reports.create', 'reports.export',
            
            // Settings
            'settings.read', 'settings.update',
        ];

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // Create roles using Spatie Permission
        $adminRole = Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $managerRole = Role::create([
            'name' => 'manager',
            'guard_name' => 'web'
        ]);

        $staffRole = Role::create([
            'name' => 'staff',
            'guard_name' => 'web'
        ]);

        $customerRole = Role::create([
            'name' => 'customer',
            'guard_name' => 'web'
        ]);

        // Assign permissions to roles
        
        // Admin gets all permissions
        $adminRole->givePermissionTo(Permission::all());

        // Manager permissions
        $managerRole->givePermissionTo([
            'companies.create', 'companies.read', 'companies.update', 'companies.delete',
            'contacts.create', 'contacts.read', 'contacts.update', 'contacts.delete',
            'leads.create', 'leads.read', 'leads.update', 'leads.delete',
            'deals.create', 'deals.read', 'deals.update', 'deals.delete',
            'jobs.create', 'jobs.read', 'jobs.update', 'jobs.assign',
            'tasks.create', 'tasks.read', 'tasks.update', 'tasks.assign',
            'time.read', 'time.approve',
            'expenses.read', 'expenses.approve',
            'invoices.create', 'invoices.read', 'invoices.update',
            'payments.read',
            'reports.view', 'reports.create',
        ]);

        // Staff permissions
        $staffRole->givePermissionTo([
            'contacts.read', 'contacts.update',
            'leads.read', 'leads.update',
            'deals.read', 'deals.update',
            'jobs.read', 'jobs.update',
            'tasks.read', 'tasks.update',
            'time.create', 'time.read', 'time.update',
            'expenses.create', 'expenses.read',
        ]);

        // Customer permissions (portal access)
        $customerRole->givePermissionTo([
            'invoices.read',
            'payments.create',
        ]);

        $this->command->info('✅ Roles and permissions seeded successfully');
    }
}
