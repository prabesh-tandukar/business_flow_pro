<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'VIP Client', 'color' => '#DC2626', 'description' => 'High-value customer', 'tag_type' => 'customer_status'],
            ['name' => 'Hot Lead', 'color' => '#EA580C', 'description' => 'High-priority prospect', 'tag_type' => 'lead_status'],
            ['name' => 'Cold Lead', 'color' => '#0EA5E9', 'description' => 'Low-priority prospect', 'tag_type' => 'lead_status'],
            ['name' => 'Decision Maker', 'color' => '#7C2D12', 'description' => 'Key decision maker', 'tag_type' => 'contact_role'],
            ['name' => 'Technical Contact', 'color' => '#166534', 'description' => 'Technical point of contact', 'tag_type' => 'contact_role'],
            ['name' => 'Enterprise', 'color' => '#581C87', 'description' => 'Large enterprise client', 'tag_type' => 'company_size'],
            ['name' => 'SMB', 'color' => '#1E40AF', 'description' => 'Small/medium business', 'tag_type' => 'company_size'],
            ['name' => 'Startup', 'color' => '#059669', 'description' => 'Startup company', 'tag_type' => 'company_size'],
            ['name' => 'Long-term Client', 'color' => '#7C3AED', 'description' => 'Established long-term relationship', 'tag_type' => 'relationship'],
            ['name' => 'New Client', 'color' => '#10B981', 'description' => 'Recently acquired client', 'tag_type' => 'relationship'],
            ['name' => 'Referral Source', 'color' => '#F59E0B', 'description' => 'Source of referrals', 'tag_type' => 'special'],
            ['name' => 'High Value', 'color' => '#DC2626', 'description' => 'High value opportunity', 'tag_type' => 'financial'],
            ['name' => 'Budget Conscious', 'color' => '#6B7280', 'description' => 'Price-sensitive client', 'tag_type' => 'financial'],
            ['name' => 'Quick Decision', 'color' => '#065F46', 'description' => 'Fast decision maker', 'tag_type' => 'behavior'],
            ['name' => 'Requires Follow-up', 'color' => '#B45309', 'description' => 'Needs regular follow-up', 'tag_type' => 'behavior'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }

        $this->command->info('✅ Tags seeded successfully - ' . count($tags) . ' tags created');
    }
}