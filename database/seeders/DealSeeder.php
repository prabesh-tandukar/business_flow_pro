<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Deal;
use App\Models\Lead;
use App\Models\User;
use App\Models\DealStage;
use App\Models\DealType;
use App\Models\Product;

class DealSeeder extends Seeder
{
    public function run(): void
    {
        $convertedLeads = Lead::whereNotNull('converted_at')->get();
        $users = User::where('email', '!=', 'admin@businessflow.com')->get();
        $stages = DealStage::all();
        $types = DealType::all();
        $products = Product::all();

        $createdDeals = [];

        // Create deals from converted leads
        foreach ($convertedLeads as $lead) {
            $stage = $stages->random();
            
            $deal = Deal::create([
                'name' => 'Deal: ' . $lead->title,
                'company_id' => $lead->contact->company_id,
                'contact_id' => $lead->contact_id,
                'lead_id' => $lead->id,
                'owner_id' => $lead->owner_id,
                'stage_id' => $stage->id,
                'type_id' => $types->random()->id,
                'amount' => $lead->estimated_value * (rand(90, 110) / 100), // Slight variation
                'currency' => 'USD',
                'probability' => $stage->probability,
                'expected_close_date' => $lead->expected_close_date,
                'description' => $lead->description,
                'requirements' => $lead->requirements,
                'competitors' => ['Competitor A', 'Competitor B', 'In-house team'][rand(0, 2)],
                'next_steps' => 'Follow up with proposal details',
                'created_at' => $lead->converted_at,
                'updated_at' => now()->subDays(rand(1, 7)),
                'last_activity_at' => now()->subDays(rand(1, 14)),
            ]);

            // Mark converted lead with deal reference
            $lead->update(['converted_to_deal_id' => $deal->id]);

            $createdDeals[] = $deal;
        }

        // Create some additional deals without leads (direct deals)
        for ($i = 0; $i < 8; $i++) {
            $stage = $stages->random();
            $user = $users->random();
            
            $deal = Deal::create([
                'name' => 'Direct Deal #' . ($i + 1),
                'company_id' => $user->companies()->first()?->id,
                'contact_id' => $user->contacts()->first()?->id,
                'owner_id' => $user->id,
                'stage_id' => $stage->id,
                'type_id' => $types->random()->id,
                'amount' => rand(1000, 10000),
                'currency' => 'USD',
                'probability' => $stage->probability,
                'expected_close_date' => now()->addDays(rand(30, 120)),
                'description' => 'Direct deal opportunity',
                'requirements' => 'Custom requirements for direct deal',
                'next_steps' => 'Schedule discovery call',
                'created_at' => now()->subDays(rand(1, 60)),
                'updated_at' => now()->subDays(rand(1, 7)),
                'last_activity_at' => now()->subDays(rand(1, 14)),
            ]);

            $createdDeals[] = $deal;
        }

        // Add products to deals
        foreach ($createdDeals as $deal) {
            $dealProducts = $products->random(rand(1, 3));
            
            foreach ($dealProducts as $product) {
                $quantity = rand(1, 5);
                $unitPrice = $product->unit_price * (rand(90, 110) / 100); // Price variation
                
                $deal->products()->attach($product->id, [
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'discount_percent' => rand(0, 15),
                    'discount_amount' => 0,
                    'line_total' => $quantity * $unitPrice,
                    'notes' => 'Added to deal package',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Close some deals (won/lost)
        $wonStage = DealStage::where('is_won', true)->first();
        $lostStage = DealStage::where('is_closed', true)->where('is_won', false)->first();

        if ($wonStage && $lostStage) {
            // Mark some as won
            $dealsToWin = collect($createdDeals)->random(rand(3, 6));
            foreach ($dealsToWin as $deal) {
                $deal->update([
                    'stage_id' => $wonStage->id,
                    'is_won' => true,
                    'actual_close_date' => now()->subDays(rand(1, 30)),
                    'closed_at' => now()->subDays(rand(1, 30)),
                ]);
            }

            // Mark some as lost
            $dealsToLose = collect($createdDeals)->random(rand(2, 4));
            foreach ($dealsToLose as $deal) {
                if (!$deal->is_won) { // Don't change already won deals
                    $deal->update([
                        'stage_id' => $lostStage->id,
                        'is_won' => false,
                        'lost_reason' => ['Budget constraints', 'Chose competitor', 'Project cancelled', 'Timing not right'][rand(0, 3)],
                        'actual_close_date' => now()->subDays(rand(1, 30)),
                        'closed_at' => now()->subDays(rand(1, 30)),
                    ]);
                }
            }
        }

        $this->command->info('✅ Deals seeded successfully - ' . count($createdDeals) . ' deals created');
    }
}
