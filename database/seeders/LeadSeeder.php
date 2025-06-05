<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lead;
use App\Models\Contact;
use App\Models\User;
use App\Models\LeadStatus;
use App\Models\LeadSource;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = Contact::all();
        $users = User::where('email', '!=', 'admin@businessflow.com')->get(); // Exclude admin
        $statuses = LeadStatus::all();
        $sources = LeadSource::all();

        $leadTemplates = [
            [
                'title' => 'Website Redesign Project',
                'description' => 'Looking for a complete website redesign with modern design',
                'estimated_value' => 3500.00,
                'probability' => 70,
                'temperature' => 'hot',
                'requirements' => 'Responsive design, CMS integration, SEO optimization',
                'budget_range' => '$3,000 - $5,000',
                'decision_timeframe' => '2-3 months',
            ],
            [
                'title' => 'Digital Marketing Campaign',
                'description' => 'Need comprehensive digital marketing strategy',
                'estimated_value' => 2000.00,
                'probability' => 50,
                'temperature' => 'warm',
                'requirements' => 'SEO, PPC, Social media marketing',
                'budget_range' => '$1,500 - $2,500',
                'decision_timeframe' => '1-2 months',
            ],
            [
                'title' => 'E-commerce Development',
                'description' => 'Build new e-commerce platform',
                'estimated_value' => 8000.00,
                'probability' => 40,
                'temperature' => 'warm',
                'requirements' => 'Payment integration, inventory management, mobile app',
                'budget_range' => '$6,000 - $10,000',
                'decision_timeframe' => '3-6 months',
            ],
            [
                'title' => 'Logo and Branding',
                'description' => 'Complete brand identity package needed',
                'estimated_value' => 1200.00,
                'probability' => 80,
                'temperature' => 'hot',
                'requirements' => 'Logo design, brand guidelines, business cards',
                'budget_range' => '$800 - $1,500',
                'decision_timeframe' => '2-4 weeks',
            ],
            [
                'title' => 'IT Support Services',
                'description' => 'Ongoing IT support for growing business',
                'estimated_value' => 1800.00,
                'probability' => 60,
                'temperature' => 'warm',
                'requirements' => 'Monthly support, server maintenance, security',
                'budget_range' => '$300 - $500/month',
                'decision_timeframe' => '1 month',
            ],
        ];

        $createdLeads = [];

        // Create 35-40 leads
        for ($i = 0; $i < 38; $i++) {
            $contact = $contacts->random();
            $template = $leadTemplates[array_rand($leadTemplates)];
            
            $lead = Lead::create([
                'contact_id' => $contact->id,
                'status_id' => $statuses->random()->id,
                'source_id' => $sources->random()->id,
                'owner_id' => $users->random()->id,
                'title' => $template['title'] . ($i > count($leadTemplates) ? ' #' . ($i - count($leadTemplates) + 1) : ''),
                'description' => $template['description'],
                'estimated_value' => $template['estimated_value'] * (rand(80, 120) / 100), // Vary by ±20%
                'probability' => rand(10, 90),
                'expected_close_date' => now()->addDays(rand(30, 180)),
                'lead_score' => rand(1, 100),
                'temperature' => ['cold', 'warm', 'hot'][rand(0, 2)],
                'requirements' => $template['requirements'],
                'budget_range' => $template['budget_range'],
                'decision_timeframe' => $template['decision_timeframe'],
                'decision_makers' => 'CEO, CTO, Marketing Director',
                'last_activity_at' => now()->subDays(rand(1, 30)),
                'created_at' => now()->subDays(rand(1, 90)),
                'updated_at' => now()->subDays(rand(1, 7)),
            ]);

            $createdLeads[] = $lead;
        }

        // Convert some leads (set converted status and date)
        $convertedStatus = LeadStatus::where('is_converted', true)->first();
        if ($convertedStatus) {
            $leadsToConvert = collect($createdLeads)->random(rand(8, 12));
            foreach ($leadsToConvert as $lead) {
                $lead->update([
                    'status_id' => $convertedStatus->id,
                    'converted_at' => now()->subDays(rand(1, 60)),
                ]);
            }
        }

        $this->command->info('✅ Leads seeded successfully - ' . count($createdLeads) . ' leads created');
    }
}
