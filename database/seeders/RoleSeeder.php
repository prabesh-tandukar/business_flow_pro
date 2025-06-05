<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Full system access with all permissions',
                'permissions' => json_encode([
                    'users.*', 'companies.*', 'contacts.*', 'leads.*', 'deals.*',
                    'jobs.*', 'tasks.*', 'time.*', 'expenses.*', 'invoices.*',
                    'payments.*', 'reports.*', 'settings.*', 'system.*'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'manager',
                'description' => 'Management access with team oversight permissions',
                'permissions' => json_encode([
                    'companies.*', 'contacts.*', 'leads.*', 'deals.*', 'jobs.*', 
                    'tasks.*', 'time.approve', 'expenses.approve', 'invoices.*', 
                    'payments.read', 'reports.view', 'team.manage'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'staff',
                'description' => 'Standard staff access for daily operations',
                'permissions' => json_encode([
                    'contacts.read', 'contacts.update', 'leads.read', 'leads.update',
                    'deals.read', 'deals.update', 'jobs.read', 'jobs.update',
                    'tasks.*', 'time.*', 'expenses.create', 'expenses.read'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'customer',
                'description' => 'Customer portal access',
                'permissions' => json_encode([
                    'portal.access', 'invoices.read_own', 'payments.make',
                    'quotes.view_own', 'documents.view_own'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('roles')->insert($roles);
        
        $this->command->info('✅ Roles seeded successfully');
    }
}
