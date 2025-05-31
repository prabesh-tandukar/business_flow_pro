<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceCategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('service_categories')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'Consulting',
                'description' => 'Business and technical consulting services',
                'parent_id' => null,
                'icon' => 'briefcase',
                'color' => '#3B82F6',
                'is_active' => true,
                'display_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Development',
                'description' => 'Software and web development services',
                'parent_id' => null,
                'icon' => 'code',
                'color' => '#10B981',
                'is_active' => true,
                'display_order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Design',
                'description' => 'Graphic design and creative services',
                'parent_id' => null,
                'icon' => 'palette',
                'color' => '#8B5CF6',
                'is_active' => true,
                'display_order' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Marketing',
                'description' => 'Digital marketing and advertising services',
                'parent_id' => null,
                'icon' => 'megaphone',
                'color' => '#F59E0B',
                'is_active' => true,
                'display_order' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Support',
                'description' => 'Technical support and maintenance services',
                'parent_id' => null,
                'icon' => 'support',
                'color' => '#EF4444',
                'is_active' => true,
                'display_order' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}