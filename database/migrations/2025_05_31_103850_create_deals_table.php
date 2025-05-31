<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->uuid('company_id')->nullable();
            $table->uuid('contact_id')->nullable();
            $table->uuid('lead_id')->nullable();
            $table->uuid('owner_id');
            
            // Deal classification
            $table->unsignedBigInteger('stage_id');
            $table->unsignedBigInteger('type_id')->nullable();
            
            // Financial details
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            $table->decimal('probability', 5, 2)->default(0.00);
            $table->date('expected_close_date')->nullable();
            $table->date('actual_close_date')->nullable();
            
            // Deal details
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->text('competitors')->nullable();
            $table->text('next_steps')->nullable();
            
            // Status and tracking
            $table->boolean('is_won')->nullable();
            $table->text('lost_reason')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('contact_id')->references('id')->on('contacts');
            $table->foreign('lead_id')->references('id')->on('leads');
            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('stage_id')->references('id')->on('deal_stages');
            $table->foreign('type_id')->references('id')->on('deal_types');
            
            
            
            // Indexes
            $table->index(['stage_id'], 'idx_deals_stage');
            $table->index(['owner_id'], 'idx_deals_owner');
            $table->index(['company_id'], 'idx_deals_company');
            $table->index(['expected_close_date'], 'idx_deals_expected_close');
            $table->index(['amount'], 'idx_deals_amount');
            $table->index(['is_won'], 'idx_deals_won');
        });

        // Add foreign key back to leads table
        Schema::table('leads', function (Blueprint $table) {
            $table->foreign('converted_to_deal_id')->references('id')->on('deals');
        });
    }

    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['converted_to_deal_id']);
        });
        
        Schema::dropIfExists('deals');
    }
};