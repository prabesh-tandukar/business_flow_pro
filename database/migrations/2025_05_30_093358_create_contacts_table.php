<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
             $table->uuid('id')->primary();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('job_title', 100)->nullable();
            $table->string('department', 100)->nullable();
            
            // Address (can be different from company)
            $table->text('address_line_1')->nullable();
            $table->text('address_line_2')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100)->nullable();

             // Relationships
            $table->uuid('company_id')->nullable();
            $table->uuid('owner_id');
            
            // Contact details
            $table->text('description')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->jsonb('social_profiles')->nullable();
            $table->string('preferred_contact_method', 20)->nullable();
            
            // Status and tracking
            $table->boolean('is_active')->default(true);
            $table->string('lead_source', 50)->nullable();
            $table->timestamp('last_contacted_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('owner_id')->references('id')->on('users');

             // Indexes
            $table->index(['email'], 'idx_contacts_email');
            $table->index(['company_id'], 'idx_contacts_company');
            $table->index(['owner_id'], 'idx_contacts_owner');
            $table->index(['last_contacted_at'], 'idx_contacts_last_contacted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
