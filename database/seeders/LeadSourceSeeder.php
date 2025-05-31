<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadSourceSeeder extends Seeder
{
    public function run()
    {
        DB::table('lead_sources')->insert([
            ['name' => 'Website', 'description' => 'Lead from company website', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Referral', 'description' => 'Referred by existing customer', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Social Media', 'description' => 'From social media channels', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cold Call', 'description' => 'Cold calling campaign', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Google Ads', 'description' => 'Google advertising', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Email Campaign', 'description' => 'Email marketing campaign', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Trade Show', 'description' => 'Trade show or conference', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}