<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'description' => 'Website design and development services',
                'icon' => 'code',
                'color' => '#3B82F6',
                'display_order' => 1,
            ],
            [
                'name' => 'Digital Marketing',
                'description' => 'SEO, PPC, and social media marketing',
                'icon' => 'megaphone',
                'color' => '#10B981',
                'display_order' => 2,
            ],
            [
                'name' => 'Business Consulting',
                'description' => 'Strategic business consulting services',
                'icon' => 'briefcase',
                'color' => '#8B5CF6',
                'display_order' => 3,
            ],
            [
                'name' => 'Graphic Design',
                'description' => 'Logo, branding, and graphic design',
                'icon' => 'palette',
                'color' => '#F59E0B',
                'display_order' => 4,
            ],
            [
                'name' => 'IT Support',
                'description' => 'Technical support and maintenance',
                'icon' => 'wrench',
                'color' => '#EF4444',
                'display_order' => 5,
            ],
            [
                'name' => 'Content Creation',
                'description' => 'Content writing and copywriting services',
                'icon' => 'edit',
                'color' => '#06B6D4',
                'display_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create($category);
        }

        $this->command->info('✅ Service categories seeded successfully');
    }
}
