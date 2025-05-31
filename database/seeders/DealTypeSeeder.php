<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DealTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('deal_types')->insert([
            ['name' => 'New Business', 'description' => 'New customer acquisition', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Existing Customer', 'description' => 'Upsell to existing customer', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Renewal', 'description' => 'Contract renewal', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cross-sell', 'description' => 'Additional products/services', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}