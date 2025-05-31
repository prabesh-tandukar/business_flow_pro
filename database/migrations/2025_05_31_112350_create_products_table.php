<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('code', 50)->unique()->nullable(); // SKU or service code
            $table->text('description')->nullable();
            $table->uuid('category_id')->nullable();
            
            // Pricing
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('cost_price', 10, 2)->default(0); // For profit calculation
            $table->string('currency', 3)->default('USD');
            
            // Service-specific fields
            $table->string('service_type', 20)->default('one_time'); // one_time, recurring, usage_based
            $table->string('billing_cycle', 20)->nullable(); // hourly, daily, weekly, monthly, quarterly, yearly
            $table->decimal('estimated_hours', 6, 2)->nullable(); // For time-based services
            $table->integer('service_duration_days')->nullable(); // How long service lasts
            $table->decimal('setup_fee', 10, 2)->default(0);
            
            // Inventory (for physical products)
            $table->boolean('track_inventory')->default(false);
            $table->integer('stock_quantity')->default(0);
            $table->integer('low_stock_threshold')->default(5);
            
            // Pricing tiers
            $table->boolean('has_tiered_pricing')->default(false);
            $table->jsonb('pricing_tiers')->nullable(); // Array of pricing tiers
            
            // Requirements and skills
            $table->jsonb('required_skills')->nullable(); // TEXT[] equivalent
            $table->integer('complexity_level')->default(1); // 1-5 scale
            $table->text('prerequisites')->nullable();
            
            // Tax and billing
            $table->boolean('is_taxable')->default(true);
            $table->string('tax_category', 50)->nullable();
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('service_categories');
            
            // Indexes
            $table->index(['category_id'], 'idx_products_category');
            $table->index(['is_active'], 'idx_products_active');
            $table->index(['service_type'], 'idx_products_service_type');
            $table->index(['unit_price'], 'idx_products_price');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};