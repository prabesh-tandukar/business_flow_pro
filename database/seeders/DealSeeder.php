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

        if ($convertedLeads->isEmpty()) {
            $this->command->warn('⚠️ No converted leads found. Creating some deals without leads.');
        }

        $createdDeals = [];

        // Create deals from converted leads
        foreach ($convertedLeads as $lead) {
            $stage = $stages->random();
            
            $dealData = [
                'name' => 'Deal: ' . $lead->title,
                'contact_id' => $lead->contact_id,
                'lead_id' => $lead->id,
                'owner_id' => $lead->owner_id,
                'stage_id' => $stage->id,
                'type_id' => $types->random()->id,
                'amount' => $lead->estimated_value * (rand(90, 110) / 100),
                'currency' => 'USD',
                'probability' => rand(10, 90),
                'expected_close_date' => $lead->expected_close_date,
                'description' => $lead->description,
                'created_at' => $lead->converted_at,
                'updated_at' => now()->subDays(rand(1, 7)),
            ];

            $deal = Deal::create($dealData);
            $createdDeals[] = $deal;
        }

        // Create some additional deals
        for ($i = 0; $i < 5; $i++) {
            $stage = $stages->random();
            $user = $users->random();
            
            $dealData = [
                'name' => 'Direct Deal #' . ($i + 1),
                'owner_id' => $user->id,
                'stage_id' => $stage->id,
                'type_id' => $types->random()->id,
                'amount' => rand(1000, 10000),
                'currency' => 'USD',
                'probability' => rand(10, 90),
                'expected_close_date' => now()->addDays(rand(30, 120)),
                'description' => 'Direct deal opportunity',
                'created_at' => now()->subDays(rand(1, 60)),
                'updated_at' => now()->subDays(rand(1, 7)),
            ];

            $deal = Deal::create($dealData);
            $createdDeals[] = $deal;
        }

        // Add products to deals if products exist
        if ($products->isNotEmpty()) {
            foreach ($createdDeals as $deal) {
                $dealProducts = $products->random(rand(1, 2));
                
                foreach ($dealProducts as $product) {
                    $quantity = rand(1, 3);
                    $unitPrice = $product->unit_price;
                    
                    $deal->products()->attach($product->id, [
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'line_total' => $quantity * $unitPrice,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        $this->command->info('✅ Deals seeded successfully - ' . count($createdDeals) . ' deals created');
    }
}