<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('deal_products', function (Blueprint $table) {
            
            $table->uuid('deal_id');
            $table->uuid('product_id');
            $table->decimal('quantity', 10, 2)->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('line_total', 12, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('deal_id')->references('id')->on('deals')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products');
            
// Add composite primary key
            $table->primary(['deal_id', 'product_id']);

            // Indexes
            $table->index(['deal_id'], 'idx_deal_products_deal');
            $table->index(['product_id'], 'idx_deal_products_product');
        });
    }

    public function down()
    {
        Schema::dropIfExists('deal_products');
    }
};