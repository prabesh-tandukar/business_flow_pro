<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'VIP Client', 'color' => '#DC2626', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hot Lead', 'color' => '#EA580C', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cold Lead', 'color' => '#0EA5E9', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Decision Maker', 'color' => '#7C2D12', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Technical Contact', 'color' => '#166534', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Enterprise', 'color' => '#581C87', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SMB', 'color' => '#1E40AF', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Startup', 'color' => '#059669', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Long-term Client', 'color' => '#7C3AED', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'New Client', 'color' => '#10B981', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Referral Source', 'color' => '#F59E0B', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'High Value', 'color' => '#DC2626', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('tags')->insert($tags);
        $this->command->info('✅ Tags seeded successfully - ' . count($tags) . ' tags created');
    }
}