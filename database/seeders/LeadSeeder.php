<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lead;
use App\Models\Contact;
use App\Models\User;
use App\Models\LeadStatus;
use App\Models\LeadSource;
use Illuminate\Support\Str;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = Contact::all();
        $users = User::all();
        $statuses = LeadStatus::all();
        $sources = LeadSource::all();

        if ($contacts->isEmpty()) {
            $this->command->warn('⚠️ No contacts found. Please run ContactSeeder first.');
            return;
        }

        if ($users->isEmpty()) {
            $this->command->warn('⚠️ No users found. Please run UserSeeder first.');
            return;
        }

        $leadTemplates = [
            [
                'title' => 'Website Redesign Project',
                'description' => 'Looking for a complete website redesign with modern design, responsive layout, and improved user experience',
                'estimated_value' => 3500.00,
            ],
            [
                'title' => 'Digital Marketing Campaign',
                'description' => 'Need comprehensive digital marketing strategy including SEO, PPC, and social media management',
                'estimated_value' => 2000.00,
            ],
            [
                'title' => 'E-commerce Development',
                'description' => 'Build new e-commerce platform with payment integration, inventory management, and mobile optimization',
                'estimated_value' => 8000.00,
            ],
            [
                'title' => 'Logo and Branding',
                'description' => 'Complete brand identity package including logo design, brand guidelines, and marketing materials',
                'estimated_value' => 1200.00,
            ],
            [
                'title' => 'SEO Optimization',
                'description' => 'Improve search engine rankings through technical SEO, content optimization, and link building',
                'estimated_value' => 1500.00,
            ],
            [
                'title' => 'Social Media Setup',
                'description' => 'Setup and manage social media presence across multiple platforms with content strategy',
                'estimated_value' => 800.00,
            ],
            [
                'title' => 'Business Consulting',
                'description' => 'Strategic business planning, process optimization, and growth strategy development',
                'estimated_value' => 2500.00,
            ],
            [
                'title' => 'IT Support Contract',
                'description' => 'Ongoing IT support, system maintenance, security monitoring, and help desk services',
                'estimated_value' => 1800.00,
            ],
        ];

        $createdLeads = [];

        // Create 25 leads
        for ($i = 0; $i < 25; $i++) {
            $contact = $contacts->random();
            $template = $leadTemplates[$i % count($leadTemplates)];
            
            $leadData = [
                'id' => Str::uuid(), // Generate UUID for primary key
                'title' => $template['title'] . ($i >= count($leadTemplates) ? ' #' . ($i - count($leadTemplates) + 2) : ''),
                'description' => $template['description'],
                'contact_id' => $contact->id,
                'owner_id' => $users->random()->id,
                'status_id' => $statuses->isNotEmpty() ? $statuses->random()->id : null,
                'source_id' => $sources->isNotEmpty() ? $sources->random()->id : null,
                'estimated_value' => $template['estimated_value'] * (rand(80, 120) / 100), // Vary by ±20%
                'probability' => rand(10, 90),
                'expected_close_date' => now()->addDays(rand(30, 180)),
                'created_at' => now()->subDays(rand(1, 90)),
                'updated_at' => now()->subDays(rand(1, 7)),
            ];

            // Add optional fields that might exist in your leads table
            if (method_exists(Lead::class, 'getFillable') && in_array('lead_score', (new Lead())->getFillable())) {
                $leadData['lead_score'] = rand(1, 100);
            }

            if (method_exists(Lead::class, 'getFillable') && in_array('temperature', (new Lead())->getFillable())) {
                $leadData['temperature'] = ['cold', 'warm', 'hot'][rand(0, 2)];
            }

            if (method_exists(Lead::class, 'getFillable') && in_array('requirements', (new Lead())->getFillable())) {
                $leadData['requirements'] = 'Custom requirements for ' . $template['title'];
            }

            if (method_exists(Lead::class, 'getFillable') && in_array('budget_range', (new Lead())->getFillable())) {
                $low = $template['estimated_value'] * 0.8;
                $high = $template['estimated_value'] * 1.2;
                $leadData['budget_range'] = '$' . number_format($low) . ' - $' . number_format($high);
            }

            if (method_exists(Lead::class, 'getFillable') && in_array('decision_timeframe', (new Lead())->getFillable())) {
                $leadData['decision_timeframe'] = ['1-2 weeks', '1 month', '2-3 months', '3-6 months'][rand(0, 3)];
            }

            $lead = Lead::create($leadData);
            $createdLeads[] = $lead;
        }

        // Convert some leads (set converted status and date if fields exist)
        $convertedStatus = LeadStatus::where('name', 'LIKE', '%convert%')->orWhere('name', 'LIKE', '%won%')->first();
        if ($convertedStatus && method_exists(Lead::class, 'getFillable') && in_array('converted_at', (new Lead())->getFillable())) {
            $leadsToConvert = collect($createdLeads)->random(rand(5, 8));
            foreach ($leadsToConvert as $lead) {
                $lead->update([
                    'status_id' => $convertedStatus->id,
                    'converted_at' => now()->subDays(rand(1, 60)),
                ]);
            }
            $this->command->info('✅ ' . count($leadsToConvert) . ' leads marked as converted');
        }

        $this->command->info('✅ Leads seeded successfully - ' . count($createdLeads) . ' leads created');
        $this->command->info('📊 Lead distribution:');
        $this->command->info('   - Website projects: ' . collect($createdLeads)->filter(function($lead) { return str_contains($lead->title, 'Website'); })->count());
        $this->command->info('   - Marketing projects: ' . collect($createdLeads)->filter(function($lead) { return str_contains($lead->title, 'Marketing'); })->count());
        $this->command->info('   - Design projects: ' . collect($createdLeads)->filter(function($lead) { return str_contains($lead->title, 'Logo') || str_contains($lead->title, 'Brand'); })->count());
        $this->command->info('   - Other projects: ' . collect($createdLeads)->filter(function($lead) { 
            return !str_contains($lead->title, 'Website') && !str_contains($lead->title, 'Marketing') && !str_contains($lead->title, 'Logo') && !str_contains($lead->title, 'Brand'); 
        })->count());
    }
}

// =====================================================
// Also create a fixed DealSeeder with UUID support
// =====================================================

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Deal;
use App\Models\Lead;
use App\Models\Contact;
use App\Models\User;
use App\Models\DealStage;
use App\Models\DealType;
use App\Models\Product;
use Illuminate\Support\Str;

class DealSeeder extends Seeder
{
    public function run(): void
    {
        $leads = Lead::all();
        $contacts = Contact::all();
        $users = User::all();
        $stages = DealStage::all();
        $types = DealType::all();
        $products = Product::all();

        if ($contacts->isEmpty() || $users->isEmpty()) {
            $this->command->warn('⚠️ No contacts or users found. Please run ContactSeeder and UserSeeder first.');
            return;
        }

        $dealNames = [
            'Website Development Package',
            'Digital Marketing Solution',
            'Brand Identity Project',
            'SEO Optimization Campaign',
            'E-commerce Platform Build',
            'Social Media Management',
            'Business Consulting Package',
            'IT Support Agreement',
            'Content Marketing Strategy',
            'Custom Software Development'
        ];

        $createdDeals = [];

        // Create 18 deals
        for ($i = 0; $i < 18; $i++) {
            $contact = $contacts->random();
            $lead = $leads->isNotEmpty() ? $leads->random() : null;
            $nameIndex = $i % count($dealNames);
            
            $dealData = [
                'id' => Str::uuid(), // Generate UUID for primary key
                'name' => $dealNames[$nameIndex] . ' #' . ($i + 1),
                'contact_id' => $contact->id,
                'lead_id' => $lead?->id,
                'owner_id' => $users->random()->id,
                'stage_id' => $stages->isNotEmpty() ? $stages->random()->id : null,
                'type_id' => $types->isNotEmpty() ? $types->random()->id : null,
                'amount' => rand(1000, 15000),
                'currency' => 'USD',
                'probability' => rand(10, 95),
                'expected_close_date' => now()->addDays(rand(30, 180)),
                'description' => 'Deal for ' . $dealNames[$nameIndex] . ' - Comprehensive solution package #' . ($i + 1),
                'created_at' => now()->subDays(rand(1, 60)),
                'updated_at' => now()->subDays(rand(1, 7)),
            ];

            // Add optional fields that might exist
            if (method_exists(Deal::class, 'getFillable') && in_array('company_id', (new Deal())->getFillable())) {
                $dealData['company_id'] = $contact->company_id ?? null;
            }

            if (method_exists(Deal::class, 'getFillable') && in_array('requirements', (new Deal())->getFillable())) {
                $dealData['requirements'] = 'Custom requirements for ' . $dealNames[$nameIndex];
            }

            if (method_exists(Deal::class, 'getFillable') && in_array('next_steps', (new Deal())->getFillable())) {
                $dealData['next_steps'] = 'Follow up with proposal and timeline';
            }

            if (method_exists(Deal::class, 'getFillable') && in_array('competitors', (new Deal())->getFillable())) {
                $dealData['competitors'] = ['Competitor A', 'Competitor B', 'In-house team', 'Other agencies'][rand(0, 3)];
            }

            $deal = Deal::create($dealData);
            $createdDeals[] = $deal;
        }

        // Add products to deals if both models have the relationship
        if ($products->isNotEmpty() && method_exists(Deal::class, 'products')) {
            $this->attachProductsToDeals($createdDeals, $products);
        }

        // Close some deals (won/lost) if status fields exist
        $this->closeRandomDeals($createdDeals, $stages);

        $this->command->info('✅ Deals seeded successfully - ' . count($createdDeals) . ' deals created');
        $this->command->info('📊 Deal types:');
        $this->command->info('   - Development projects: ' . collect($createdDeals)->filter(function($deal) { return str_contains($deal->name, 'Development'); })->count());
        $this->command->info('   - Marketing projects: ' . collect($createdDeals)->filter(function($deal) { return str_contains($deal->name, 'Marketing'); })->count());
        $this->command->info('   - Consulting projects: ' . collect($createdDeals)->filter(function($deal) { return str_contains($deal->name, 'Consulting'); })->count());
    }

    private function attachProductsToDeals($deals, $products)
    {
        try {
            foreach ($deals as $deal) {
                $dealProducts = $products->random(rand(1, 3));
                
                foreach ($dealProducts as $product) {
                    $quantity = rand(1, 3);
                    $unitPrice = $product->unit_price * (rand(90, 110) / 100); // Price variation
                    
                    $deal->products()->attach($product->id, [
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'line_total' => $quantity * $unitPrice,
                        'discount_percent' => rand(0, 15),
                        'notes' => 'Added to deal package',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            $this->command->info('✅ Products attached to deals successfully');
        } catch (\Exception $e) {
            $this->command->info('ℹ️  Skipping product attachments: ' . $e->getMessage());
        }
    }

    private function closeRandomDeals($deals, $stages)
    {
        try {
            $wonStage = $stages->where('name', 'LIKE', '%won%')->orWhere('name', 'LIKE', '%closed%')->first();
            $lostStage = $stages->where('name', 'LIKE', '%lost%')->orWhere('name', 'LIKE', '%rejected%')->first();

            if ($wonStage) {
                $dealsToWin = collect($deals)->random(rand(2, 4));
                foreach ($dealsToWin as $deal) {
                    $updateData = ['stage_id' => $wonStage->id];
                    
                    if (method_exists(Deal::class, 'getFillable') && in_array('is_won', (new Deal())->getFillable())) {
                        $updateData['is_won'] = true;
                    }
                    
                    if (method_exists(Deal::class, 'getFillable') && in_array('actual_close_date', (new Deal())->getFillable())) {
                        $updateData['actual_close_date'] = now()->subDays(rand(1, 30));
                    }
                    
                    $deal->update($updateData);
                }
            }

            if ($lostStage) {
                $dealsToLose = collect($deals)->random(rand(1, 3));
                foreach ($dealsToLose as $deal) {
                    $updateData = ['stage_id' => $lostStage->id];
                    
                    if (method_exists(Deal::class, 'getFillable') && in_array('is_won', (new Deal())->getFillable())) {
                        $updateData['is_won'] = false;
                    }
                    
                    if (method_exists(Deal::class, 'getFillable') && in_array('lost_reason', (new Deal())->getFillable())) {
                        $updateData['lost_reason'] = ['Budget constraints', 'Chose competitor', 'Project cancelled', 'Timing not right'][rand(0, 3)];
                    }
                    
                    $deal->update($updateData);
                }
            }
        } catch (\Exception $e) {
            $this->command->info('ℹ️  Skipping deal status updates: ' . $e->getMessage());
        }
    }
}