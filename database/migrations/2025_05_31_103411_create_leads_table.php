<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('contact_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('source_id')->nullable();
            $table->uuid('owner_id');
            
            // Lead details
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->decimal('estimated_value', 12, 2)->nullable();
            $table->integer('probability')->default(0)->comment('0-100 percentage');
            $table->date('expected_close_date')->nullable();
            
            // Lead scoring
            $table->integer('lead_score')->default(0);
            $table->string('temperature', 10)->default('cold'); // cold, warm, hot
            
            // Requirements and notes
            $table->text('requirements')->nullable();
            $table->string('budget_range', 50)->nullable();
            $table->string('decision_timeframe', 50)->nullable();
            $table->text('decision_makers')->nullable();
            
            // Tracking
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamp('converted_at')->nullable();
            $table->uuid('converted_to_deal_id')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('contact_id')->references('id')->on('contacts');
            $table->foreign('status_id')->references('id')->on('lead_statuses');
            $table->foreign('source_id')->references('id')->on('lead_sources');
            $table->foreign('owner_id')->references('id')->on('users');
            
            // Indexes
            $table->index(['status_id'], 'idx_leads_status');
            $table->index(['owner_id'], 'idx_leads_owner');
            $table->index(['source_id'], 'idx_leads_source');
            $table->index(['expected_close_date'], 'idx_leads_expected_close');
            $table->index(['temperature'], 'idx_leads_temperature');
        });
    }

    public function down()
    {
        Schema::dropIfExists('leads');
    }
};