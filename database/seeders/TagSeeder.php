<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    public function run()
    {
        DB::table('tags')->insert([
            ['name' => 'Hot Lead', 'color' => '#EF4444', 'tag_type' => 'lead_status', 'description' => 'High priority lead', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'VIP Customer', 'color' => '#8B5CF6', 'tag_type' => 'customer_type', 'description' => 'Very important customer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Enterprise', 'color' => '#10B981', 'tag_type' => 'company_size', 'description' => 'Enterprise level customer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Follow Up', 'color' => '#F59E0B', 'tag_type' => 'action_required', 'description' => 'Requires follow up', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Small Business', 'color' => '#6B7280', 'tag_type' => 'company_size', 'description' => 'Small business customer', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}