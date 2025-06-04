<?php

namespace Database\Seeders;

use App\Models\DealStage;
use App\Models\DealType;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Models\ServiceCategory;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class LookupTablesSeeder extends Seeder
{
    public function run(): void
    {
        // Lead Sources
        $leadSources = [
            'Website',
            'Referral',
            'Social Media',
            'Email Campaign',
            'Trade Show',
            'Cold Call',
            'Partner',
            'Advertisement',
        ];

        foreach ($leadSources as $source) {
            LeadSource::firstOrCreate(
                ['name' => $source],
                ['is_active' => true]
            );
        }

        // Lead Statuses
        $leadStatuses = [
            ['name' => 'New', 'is_active' => true],
            ['name' => 'Contacted', 'is_active' => true],
            ['name' => 'Qualified', 'is_active' => true],
            ['name' => 'Converted', 'is_active' => true],
            ['name' => 'Lost', 'is_active' => true],
            ['name' => 'Unqualified', 'is_active' => true],
        ];

        foreach ($leadStatuses as $status) {
            LeadStatus::firstOrCreate(
                ['name' => $status['name']],
                ['is_active' => $status['is_active']]
            );
        }

        // Deal Stages
        $dealStages = [
            ['name' => 'Lead', 'probability' => 10.00],
            ['name' => 'Qualified', 'probability' => 20.00],
            ['name' => 'Proposal', 'probability' => 40.00],
            ['name' => 'Negotiation', 'probability' => 70.00],
            ['name' => 'Closed Won', 'probability' => 100.00],
            ['name' => 'Closed Lost', 'probability' => 0.00],
        ];

        foreach ($dealStages as $stage) {
            DealStage::firstOrCreate(
                ['name' => $stage['name']],
                ['probability' => $stage['probability']]
            );
        }

        // Deal Types
        $dealTypes = [
            'New Business',
            'Existing Customer',
            'Renewal',
            'Upsell',
            'Cross-sell',
        ];

        foreach ($dealTypes as $type) {
            DealType::firstOrCreate(['name' => $type]);
        }

        // Service Categories
        $categories = [
            'Web Development',
            'Mobile Development',
            'Digital Marketing',
            'Consulting',
            'Design Services',
            'Data Analytics',
            'Cloud Services',
            'Support & Maintenance',
        ];

        foreach ($categories as $category) {
            ServiceCategory::firstOrCreate(
                ['name' => $category],
                ['is_active' => true]
            );
        }

        // Tags
        $tags = [
            ['name' => 'VIP Client', 'color' => '#ff0000'],
            ['name' => 'Hot Lead', 'color' => '#ff6600'],
            ['name' => 'Enterprise', 'color' => '#0066ff'],
            ['name' => 'SMB', 'color' => '#00cc00'],
            ['name' => 'High Value', 'color' => '#cc00cc'],
            ['name' => 'Follow Up', 'color' => '#ffcc00'],
            ['name' => 'Decision Maker', 'color' => '#00cccc'],
            ['name' => 'Influencer', 'color' => '#cc6600'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(
                ['name' => $tag['name']],
                ['color' => $tag['color']]
            );
        }
    }
}