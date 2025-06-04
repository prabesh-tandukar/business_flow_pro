<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::all();

        $companies = [
            ['name' => 'TechFlow Solutions', 'industry' => 'Technology', 'size' => 'Medium'],
            ['name' => 'Global Marketing Inc', 'industry' => 'Marketing', 'size' => 'Large'],
            ['name' => 'StartupVenture Co', 'industry' => 'Technology', 'size' => 'Small'],
            ['name' => 'Enterprise Systems Ltd', 'industry' => 'Technology', 'size' => 'Large'],
            ['name' => 'Creative Design Studio', 'industry' => 'Design', 'size' => 'Small'],
            ['name' => 'Manufacturing Plus', 'industry' => 'Manufacturing', 'size' => 'Large'],
            ['name' => 'Retail Chain Corp', 'industry' => 'Retail', 'size' => 'Large'],
            ['name' => 'Healthcare Innovations', 'industry' => 'Healthcare', 'size' => 'Medium'],
            ['name' => 'Financial Services Group', 'industry' => 'Finance', 'size' => 'Large'],
            ['name' => 'Local Restaurant Group', 'industry' => 'Food & Beverage', 'size' => 'Small'],
            ['name' => 'Construction Partners', 'industry' => 'Construction', 'size' => 'Medium'],
            ['name' => 'Education Platform', 'industry' => 'Education', 'size' => 'Medium'],
            ['name' => 'Energy Solutions Inc', 'industry' => 'Energy', 'size' => 'Large'],
            ['name' => 'Logistics Network', 'industry' => 'Transportation', 'size' => 'Medium'],
            ['name' => 'Real Estate Holdings', 'industry' => 'Real Estate', 'size' => 'Large'],
        ];

        foreach ($companies as $companyData) {
            Company::create([
                'name' => $companyData['name'],
                'industry' => $companyData['industry'],
                'website' => 'https://www.' . strtolower(str_replace(' ', '', $companyData['name'])) . '.com',
                'phone' => $faker->phoneNumber(),
                'email' => 'info@' . strtolower(str_replace(' ', '', $companyData['name'])) . '.com',
                'address_line_1' => $faker->streetAddress(),
                'city' => $faker->city(),
                'state' => $faker->state(),
                'postal_code' => $faker->postcode(),
                'country' => $faker->country(),
                'description' => $faker->paragraph(3),
                'owner_id' => $users->random()->id,
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Created ' . count($companies) . ' companies');
    }
}