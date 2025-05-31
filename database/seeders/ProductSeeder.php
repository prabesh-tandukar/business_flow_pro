<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Get category IDs (we'll use first ones for demo)
        $consultingCategory = DB::table('service_categories')->where('name', 'Consulting')->first();
        $developmentCategory = DB::table('service_categories')->where('name', 'Development')->first();

        DB::table('products')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'Business Strategy Consulting',
                'code' => 'BSC-001',
                'description' => 'Comprehensive business strategy development and implementation',
                'category_id' => $consultingCategory->id,
                'unit_price' => 150.00,
                'cost_price' => 75.00,
                'currency' => 'USD',
                'service_type' => 'one_time',
                'billing_cycle' => 'hourly',
                'estimated_hours' => 40.00,
                'setup_fee' => 0.00,
                'track_inventory' => false,
                'has_tiered_pricing' => false,
                'complexity_level' => 4,
                'is_taxable' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Web Application Development',
                'code' => 'WAD-001',
                'description' => 'Custom web application development with modern technologies',
                'category_id' => $developmentCategory->id,
                'unit_price' => 125.00,
                'cost_price' => 60.00,
                'currency' => 'USD',
                'service_type' => 'one_time',
                'billing_cycle' => 'hourly',
                'estimated_hours' => 120.00,
                'setup_fee' => 500.00,
                'track_inventory' => false,
                'has_tiered_pricing' => false,
                'complexity_level' => 5,
                'is_taxable' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Monthly Website Maintenance',
                'code' => 'MWM-001',
                'description' => 'Monthly website maintenance and updates',
                'category_id' => $developmentCategory->id,
                'unit_price' => 299.00,
                'cost_price' => 100.00,
                'currency' => 'USD',
                'service_type' => 'recurring',
                'billing_cycle' => 'monthly',
                'estimated_hours' => 8.00,
                'setup_fee' => 0.00,
                'track_inventory' => false,
                'has_tiered_pricing' => false,
                'complexity_level' => 2,
                'is_taxable' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}