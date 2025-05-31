<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadStatusSeeder extends Seeder
{
    public function run()
    {
        DB::table('lead_statuses')->insert([
            ['name' => 'New', 'description' => 'Newly created lead', 'is_active' => true, 'is_converted' => false, 'display_order' => 1, 'color' => '#6B7280', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Contacted', 'description' => 'Initial contact made', 'is_active' => true, 'is_converted' => false, 'display_order' => 2, 'color' => '#3B82F6', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Qualified', 'description' => 'Lead has been qualified', 'is_active' => true, 'is_converted' => false, 'display_order' => 3, 'color' => '#10B981', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Proposal Sent', 'description' => 'Proposal has been sent', 'is_active' => true, 'is_converted' => false, 'display_order' => 4, 'color' => '#F59E0B', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Negotiating', 'description' => 'In negotiation phase', 'is_active' => true, 'is_converted' => false, 'display_order' => 5, 'color' => '#8B5CF6', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Converted', 'description' => 'Converted to deal', 'is_active' => true, 'is_converted' => true, 'display_order' => 6, 'color' => '#10B981', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lost', 'description' => 'Lead was lost', 'is_active' => true, 'is_converted' => false, 'display_order' => 7, 'color' => '#EF4444', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}