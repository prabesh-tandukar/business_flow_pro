<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Starting Business Flow Pro CRM Database Seeding...');
        
        try {
            // Step 1: Essential data first
            $this->command->info('Step 1: Creating roles and permissions...');
            $this->call(RoleSeeder::class);
            
            $this->command->info('Step 2: Creating lookup tables...');
            $this->call(LookupTablesSeeder::class);
            
            $this->command->info('Step 3: Creating users...');
            $this->call(UserSeeder::class);
            
            $this->command->info('Step 4: Creating companies...');
            $this->call(CompanySeeder::class);
            
            $this->command->info('Step 5: Creating contacts...');
            $this->call(ContactSeeder::class);
            
            $this->command->info('Step 6: Creating products...');
            $this->call(ProductSeeder::class);
            
            $this->command->info('Step 7: Creating leads...');
            $this->call(LeadSeeder::class);
            
            $this->command->info('Step 8: Creating deals...');
            $this->call(DealSeeder::class);
            
        } catch (\Exception $e) {
            $this->command->error('❌ Seeding failed: ' . $e->getMessage());
            $this->command->info('Try running seeders individually to find the issue.');
        }

        $this->command->info('✅ Database seeding completed!');
    }
}