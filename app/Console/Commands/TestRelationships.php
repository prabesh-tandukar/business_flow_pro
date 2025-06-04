<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use App\Models\DealStage;
use App\Models\DealType;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Models\Product;
use App\Models\ServiceCategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestRelationships extends Command
{
    protected $signature = 'test:relationships';
    protected $description = 'Test all model relationships';

    public function handle()
    {
        $this->info('🧪 Testing Model Relationships...');
        $this->newLine();

        try {
            // Test User relationships
            $this->testUserRelationships();
            
            // Test Company relationships
            $this->testCompanyRelationships();
            
            // Test Contact relationships
            $this->testContactRelationships();
            
            // Test Lead relationships
            $this->testLeadRelationships();
            
            // Test Deal relationships
            $this->testDealRelationships();
            
            // Test Product relationships
            $this->testProductRelationships();
            
            // Test Junction models
            $this->testJunctionModels();

            $this->newLine();
            $this->info('✅ All relationship tests passed!');
            
        } catch (\Exception $e) {
            $this->error('❌ Test failed: ' . $e->getMessage());
            $this->error('File: ' . $e->getFile() . ' Line: ' . $e->getLine());
        }
    }

    private function testUserRelationships()
    {
        $this->info('Testing User relationships...');
        
        // Create test user
        $user = User::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test_' . time() . '@example.com',
            'password' => bcrypt('password'),
        ]);

        // Test user exists
        $this->assertTrue($user->exists, 'User created');
        
        // Test user companies relationship
        $this->assertTrue(method_exists($user, 'companies'), 'User has companies method');
        
        // Test user contacts relationship  
        $this->assertTrue(method_exists($user, 'contacts'), 'User has contacts method');
        
        $this->line('  ✓ User relationships work');
    }

    private function testCompanyRelationships()
    {
        $this->info('Testing Company relationships...');
        
        $user = User::first();
        
        // Create test company
        $company = Company::create([
            'name' => 'Test Company',
            'industry' => 'Technology',
            'owner_id' => $user->id,
        ]);

        // Test company relationships
        $this->assertTrue($company->exists, 'Company created');
        $this->assertTrue(method_exists($company, 'owner'), 'Company has owner method');
        $this->assertTrue(method_exists($company, 'contacts'), 'Company has contacts method');
        $this->assertTrue(method_exists($company, 'deals'), 'Company has deals method');
        
        // Test owner relationship
        $this->assertEquals($user->id, $company->owner->id, 'Company owner relationship works');
        
        $this->line('  ✓ Company relationships work');
    }

    private function testContactRelationships()
    {
        $this->info('Testing Contact relationships...');
        
        $user = User::first();
        $company = Company::first();
        
        // Create test contact
        $contact = Contact::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'company_id' => $company->id,
            'owner_id' => $user->id,
        ]);

        // Test contact relationships
        $this->assertTrue($contact->exists, 'Contact created');
        $this->assertTrue(method_exists($contact, 'company'), 'Contact has company method');
        $this->assertTrue(method_exists($contact, 'owner'), 'Contact has owner method');
        $this->assertTrue(method_exists($contact, 'tags'), 'Contact has tags method');
        $this->assertTrue(method_exists($contact, 'leads'), 'Contact has leads method');
        
        // Test relationships
        $this->assertEquals($company->id, $contact->company->id, 'Contact company relationship works');
        $this->assertEquals($user->id, $contact->owner->id, 'Contact owner relationship works');
        
        // Test full name attribute
        $this->assertEquals('John Doe', $contact->full_name, 'Contact full name attribute works');
        
        $this->line('  ✓ Contact relationships work');
    }

    private function testLeadRelationships()
    {
        $this->info('Testing Lead relationships...');
        
        // Create test lead source and status
        $leadSource = LeadSource::firstOrCreate(
         ['name' => 'Website'],
        ['is_active' => true]
        );

        $leadStatus = LeadStatus::firstOrCreate(
            ['name' => 'New'],
            [
                'is_active' => true,
                
            ]
        );
        
        $contact = Contact::first();
        $user = User::first();
        
        // Create test lead
        $lead = Lead::create([
            'contact_id' => $contact->id,
            'status_id' => $leadStatus->id,
            'source_id' => $leadSource->id,
            'owner_id' => $user->id,
            'title' => 'Test Lead',
            'estimated_value' => 5000.00,
        ]);

        // Test lead relationships
        $this->assertTrue($lead->exists, 'Lead created');
        $this->assertTrue(method_exists($lead, 'contact'), 'Lead has contact method');
        $this->assertTrue(method_exists($lead, 'status'), 'Lead has status method');
        $this->assertTrue(method_exists($lead, 'source'), 'Lead has source method');
        $this->assertTrue(method_exists($lead, 'owner'), 'Lead has owner method');
        
        // Test relationships
        $this->assertEquals($contact->id, $lead->contact->id, 'Lead contact relationship works');
        $this->assertEquals($leadStatus->id, $lead->status->id, 'Lead status relationship works');
        $this->assertEquals($leadSource->id, $lead->source->id, 'Lead source relationship works');
        
        $this->line('  ✓ Lead relationships work');
    }

    private function testDealRelationships()
    {
        $this->info('Testing Deal relationships...');
        
        // Create test deal stage and type
        $dealStage = DealStage::firstOrCreate(
            ['name' => 'Proposal'],
            [
                'probability' => 25.00,
                
            ]
        );

        $dealType = DealType::firstOrCreate(
            ['name' => 'New Business'],
            ['is_active' => true]
        );

        
        $company = Company::first();
        $contact = Contact::first();
        $lead = Lead::first();
        $user = User::first();
        
        // Create test deal
        $deal = Deal::create([
            'name' => 'Test Deal',
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'lead_id' => $lead->id,
            'owner_id' => $user->id,
            'stage_id' => $dealStage->id,
            'type_id' => $dealType->id,
            'amount' => 10000.00,
        ]);

        

        // Test deal relationships
        $this->assertTrue($deal->exists, 'Deal created');
        $this->assertTrue(method_exists($deal, 'company'), 'Deal has company method');
        $this->assertTrue(method_exists($deal, 'contact'), 'Deal has contact method');
        $this->assertTrue(method_exists($deal, 'lead'), 'Deal has lead method');
        $this->assertTrue(method_exists($deal, 'stage'), 'Deal has stage method');
        $this->assertTrue(method_exists($deal, 'type'), 'Deal has type method');
        $this->assertTrue(method_exists($deal, 'products'), 'Deal has products method');
        
        // Test relationships
       // Test relationships
        $this->assertEquals($company->id, $deal->company->id, 'Deal company relationship works');
        $this->assertEquals($contact->id, $deal->contact->id, 'Deal contact relationship works');
        $this->assertEquals($dealStage->name, $deal->stage->name, 'Deal stage relationship works');
        $this->assertEquals($dealType->id, $deal->type->id, 'Deal type relationship works');
        
        $this->line('  ✓ Deal relationships work');
    }

    private function testProductRelationships()
    {
        $this->info('Testing Product relationships...');
        
        // Create test service category
        $category = ServiceCategory::firstOrCreate(
            ['name' => 'Web Development'],
            ['is_active' => true]
        );

        // Create test product
        $product = Product::firstOrCreate(
            ['code' => 'WEB-001'],
            [
                'name' => 'Website Design',
                'category_id' => $category->id,
                'unit_price' => 2500.00,
                'service_type' => 'one_time',
                'is_active' => true,
            ]
        );

        // Test product relationships
        $this->assertTrue($product->exists, 'Product created');
        $this->assertTrue(method_exists($product, 'category'), 'Product has category method');
        $this->assertTrue(method_exists($product, 'deals'), 'Product has deals method');
        
        // Test relationships
        $this->assertEquals($category->id, $product->category->id, 'Product category relationship works');
        $this->assertTrue($product->isService(), 'Product service check works');
        
        $this->line('  ✓ Product relationships work');
    }

    private function testJunctionModels()
    {
        $this->info('Testing Junction models...');
        
        $contact = Contact::first();
        $deal = Deal::first();
        $product = Product::first();
        
        /// Create test tag
        $tag = Tag::firstOrCreate(
            ['name' => 'VIP Client'],
            [
                'color' => '#ff0000',

            ]
        );
        
        // Test contact-tag relationship
        $contact->tags()->sync([$tag->id]);
        $contact = $contact->fresh(); // Reload the contact to get updated relationships
        $this->assertTrue($contact->tags->contains($tag), 'Contact-Tag relationship works');
        
        // Test deal-product relationship
if (!$deal->products->contains($product)) {
    $deal->products()->attach($product->id, [
        'quantity' => 1,
        'unit_price' => 2500.00,
        'line_total' => 2500.00,
    ]);
}
$deal = $deal->fresh(); // Reload to get updated relationships
        $this->assertTrue($deal->products->contains($product), 'Deal-Product relationship works');
        
        $this->line('  ✓ Junction models work');
    }

    private function assertTrue($condition, $message)
    {
        if (!$condition) {
            throw new \Exception("Assertion failed: {$message}");
        }
    }

    private function assertEquals($expected, $actual, $message)
    {
        if ($expected !== $actual) {
            throw new \Exception("Assertion failed: {$message}. Expected: {$expected}, Actual: {$actual}");
        }
    }
}