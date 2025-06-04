<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Company;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $companies = Company::all();
        $users = User::all();
        $tags = Tag::all();

        $jobTitles = [
            'CEO', 'CTO', 'CMO', 'CFO', 'VP Sales', 'VP Marketing', 'VP Operations',
            'Director of IT', 'Director of Sales', 'Director of Marketing',
            'Sales Manager', 'Marketing Manager', 'IT Manager', 'Operations Manager',
            'Business Development Manager', 'Account Manager', 'Project Manager',
            'Senior Developer', 'Lead Designer', 'Product Manager'
        ];

        // Create 2-4 contacts per company
        foreach ($companies as $company) {
            $contactCount = $faker->numberBetween(2, 4);
            
            for ($i = 0; $i < $contactCount; $i++) {
                $contact = Contact::create([
                    'first_name' => $faker->firstName(),
                    'last_name' => $faker->lastName(),
                    'email' => $faker->unique()->email(),
                    'phone' => $faker->phoneNumber(),
                    'job_title' => $faker->randomElement($jobTitles),
                    'company_id' => $company->id,
                    'owner_id' => $users->random()->id,
                    'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                    'updated_at' => now(),
                ]);

                // Randomly assign 1-3 tags to some contacts
                if ($faker->boolean(60)) { // 60% chance of having tags
                    $contactTags = $tags->random($faker->numberBetween(1, 3));
                    $contact->tags()->attach($contactTags->pluck('id'));
                }
            }
        }

        $contactCount = Contact::count();
        $this->command->info("✅ Created {$contactCount} contacts across {$companies->count()} companies");
    }
}