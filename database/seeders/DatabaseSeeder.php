<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Starting Business Flow Pro CRM Database Seeding...');
        
        // Step 1: Core system data
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            LookupTablesSeeder::class,
        ]);

        // Step 2: Service catalog
        $this->call([
            ServiceCategorySeeder::class,
            ProductSeeder::class,
            TagSeeder::class,
        ]);

        // Step 3: CRM data (with relationships)
        $this->call([
            CompanySeeder::class,
            ContactSeeder::class,
            LeadSeeder::class,
            DealSeeder::class,
        ]);

        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->info('📊 You now have:');
        $this->command->info('   - 4 User roles with permissions');
        $this->command->info('   - 6+ Service categories');
        $this->command->info('   - 15+ Products/Services');
        $this->command->info('   - 15 Tags for organization');
        $this->command->info('   - 15 Companies');
        $this->command->info('   - 30-60 Contacts');
        $this->command->info('   - 35-40 Leads');
        $this->command->info('   - 20+ Deals with products');
        $this->command->info('   - Complete relationship data for testing');
    }
}