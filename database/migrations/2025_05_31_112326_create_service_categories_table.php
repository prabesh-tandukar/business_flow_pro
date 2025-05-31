<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('service_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->uuid('parent_id')->nullable(); // For subcategories
            $table->string('icon', 50)->nullable();
            $table->string('color', 7)->default('#3B82F6');
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_id')->references('id')->on('service_categories');
            $table->index(['parent_id'], 'idx_service_categories_parent');
            $table->index(['is_active'], 'idx_service_categories_active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_categories');
    }
};