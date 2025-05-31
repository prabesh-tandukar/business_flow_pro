<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DealStageSeeder extends Seeder
{
    public function run()
    {
        DB::table('deal_stages')->insert([
            ['name' => 'Lead', 'description' => 'Initial lead stage', 'probability' => 10.00, 'display_order' => 1, 'is_closed' => false, 'is_won' => false, 'color' => '#6B7280', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Qualified', 'description' => 'Qualified opportunity', 'probability' => 25.00, 'display_order' => 2, 'is_closed' => false, 'is_won' => false, 'color' => '#3B82F6', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Proposal', 'description' => 'Proposal sent', 'probability' => 50.00, 'display_order' => 3, 'is_closed' => false, 'is_won' => false, 'color' => '#F59E0B', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Negotiation', 'description' => 'In negotiation', 'probability' => 75.00, 'display_order' => 4, 'is_closed' => false, 'is_won' => false, 'color' => '#8B5CF6', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Closed Won', 'description' => 'Deal won', 'probability' => 100.00, 'display_order' => 5, 'is_closed' => true, 'is_won' => true, 'color' => '#10B981', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Closed Lost', 'description' => 'Deal lost', 'probability' => 0.00, 'display_order' => 6, 'is_closed' => true, 'is_won' => false, 'color' => '#EF4444', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}