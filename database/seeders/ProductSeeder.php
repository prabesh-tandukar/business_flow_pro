<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ServiceCategory;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $webDev = ServiceCategory::where('name', 'Web Development')->first();
        $marketing = ServiceCategory::where('name', 'Digital Marketing')->first();
        $consulting = ServiceCategory::where('name', 'Business Consulting')->first();
        $design = ServiceCategory::where('name', 'Graphic Design')->first();
        $itSupport = ServiceCategory::where('name', 'IT Support')->first();
        $content = ServiceCategory::where('name', 'Content Creation')->first();

        $products = [
            // Web Development Services
            [
                'name' => 'Custom Website Development',
                'code' => 'WEB-001',
                'description' => 'Full custom website development with responsive design',
                'category_id' => $webDev->id,
                'unit_price' => 2500.00,
                'cost_price' => 1500.00,
                'service_type' => 'one_time',
                'estimated_hours' => 40.0,
                'required_skills' => ['HTML', 'CSS', 'JavaScript', 'PHP'],
                'complexity_level' => 3,
            ],
            [
                'name' => 'E-commerce Website',
                'code' => 'WEB-002',
                'description' => 'Complete e-commerce solution with payment integration',
                'category_id' => $webDev->id,
                'unit_price' => 4500.00,
                'cost_price' => 2800.00,
                'service_type' => 'one_time',
                'estimated_hours' => 80.0,
                'required_skills' => ['Laravel', 'Vue.js', 'Payment APIs'],
                'complexity_level' => 4,
            ],
            [
                'name' => 'Website Maintenance',
                'code' => 'WEB-003',
                'description' => 'Monthly website maintenance and updates',
                'category_id' => $webDev->id,
                'unit_price' => 150.00,
                'cost_price' => 80.00,
                'service_type' => 'recurring',
                'billing_cycle' => 'monthly',
                'estimated_hours' => 4.0,
                'complexity_level' => 2,
            ],
            [
                'name' => 'Landing Page Design',
                'code' => 'WEB-004',
                'description' => 'High-converting landing page design and development',
                'category_id' => $webDev->id,
                'unit_price' => 800.00,
                'cost_price' => 500.00,
                'service_type' => 'one_time',
                'estimated_hours' => 16.0,
                'complexity_level' => 2,
            ],

            // Digital Marketing Services
            [
                'name' => 'SEO Optimization',
                'code' => 'MKT-001',
                'description' => 'Complete SEO audit and optimization package',
                'category_id' => $marketing->id,
                'unit_price' => 1200.00,
                'cost_price' => 600.00,
                'service_type' => 'one_time',
                'estimated_hours' => 24.0,
                'required_skills' => ['SEO', 'Analytics', 'Content Strategy'],
                'complexity_level' => 3,
            ],
            [
                'name' => 'Google Ads Management',
                'code' => 'MKT-002',
                'description' => 'Monthly Google Ads campaign management',
                'category_id' => $marketing->id,
                'unit_price' => 500.00,
                'cost_price' => 250.00,
                'service_type' => 'recurring',
                'billing_cycle' => 'monthly',
                'estimated_hours' => 8.0,
                'complexity_level' => 3,
            ],
            [
                'name' => 'Social Media Marketing',
                'code' => 'MKT-003',
                'description' => 'Social media strategy and content management',
                'category_id' => $marketing->id,
                'unit_price' => 750.00,
                'cost_price' => 400.00,
                'service_type' => 'recurring',
                'billing_cycle' => 'monthly',
                'estimated_hours' => 12.0,
                'complexity_level' => 2,
            ],

            // Business Consulting
            [
                'name' => 'Business Strategy Consulting',
                'code' => 'CON-001',
                'description' => 'Strategic planning and business development consulting',
                'category_id' => $consulting->id,
                'unit_price' => 150.00,
                'cost_price' => 75.00,
                'service_type' => 'usage_based',
                'billing_cycle' => 'hourly',
                'estimated_hours' => 1.0,
                'required_skills' => ['Strategy', 'Analysis', 'Planning'],
                'complexity_level' => 4,
            ],
            [
                'name' => 'Digital Transformation',
                'code' => 'CON-002',
                'description' => 'Complete digital transformation consulting',
                'category_id' => $consulting->id,
                'unit_price' => 5000.00,
                'cost_price' => 3000.00,
                'service_type' => 'one_time',
                'estimated_hours' => 60.0,
                'complexity_level' => 5,
            ],

            // Graphic Design
            [
                'name' => 'Logo Design Package',
                'code' => 'DES-001',
                'description' => 'Complete logo design with multiple concepts',
                'category_id' => $design->id,
                'unit_price' => 600.00,
                'cost_price' => 300.00,
                'service_type' => 'one_time',
                'estimated_hours' => 12.0,
                'required_skills' => ['Adobe Illustrator', 'Branding', 'Typography'],
                'complexity_level' => 2,
            ],
            [
                'name' => 'Brand Identity Package',
                'code' => 'DES-002',
                'description' => 'Complete brand identity including logo, colors, fonts',
                'category_id' => $design->id,
                'unit_price' => 1500.00,
                'cost_price' => 800.00,
                'service_type' => 'one_time',
                'estimated_hours' => 30.0,
                'complexity_level' => 3,
            ],

            // IT Support
            [
                'name' => 'IT Support Monthly',
                'code' => 'IT-001',
                'description' => 'Monthly IT support and maintenance',
                'category_id' => $itSupport->id,
                'unit_price' => 300.00,
                'cost_price' => 150.00,
                'service_type' => 'recurring',
                'billing_cycle' => 'monthly',
                'estimated_hours' => 6.0,
                'complexity_level' => 2,
            ],
            [
                'name' => 'Server Setup & Configuration',
                'code' => 'IT-002',
                'description' => 'Complete server setup and configuration',
                'category_id' => $itSupport->id,
                'unit_price' => 800.00,
                'cost_price' => 400.00,
                'service_type' => 'one_time',
                'estimated_hours' => 16.0,
                'required_skills' => ['Linux', 'Networking', 'Security'],
                'complexity_level' => 4,
            ],

            // Content Creation
            [
                'name' => 'Blog Content Writing',
                'code' => 'CON-001',
                'description' => 'Professional blog post writing service',
                'category_id' => $content->id,
                'unit_price' => 100.00,
                'cost_price' => 50.00,
                'service_type' => 'usage_based',
                'billing_cycle' => 'per_post',
                'estimated_hours' => 3.0,
                'complexity_level' => 2,
            ],
            [
                'name' => 'Website Copywriting',
                'code' => 'CON-002',
                'description' => 'Complete website copywriting package',
                'category_id' => $content->id,
                'unit_price' => 800.00,
                'cost_price' => 400.00,
                'service_type' => 'one_time',
                'estimated_hours' => 16.0,
                'required_skills' => ['Copywriting', 'SEO', 'Marketing'],
                'complexity_level' => 3,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('✅ Products seeded successfully - ' . count($products) . ' services created');
    }
}
