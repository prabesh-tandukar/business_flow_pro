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
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('industry', 100)->nullable();
            $table->string('website')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();

            //Address fields
            $table->text('address_line_1')->nullable();
            $table->text('address_line_2')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100)->nullable();

            //Business details
            $table->text('description')->nullable();
            $table->integer('employees_count')->nullable();
            $table->decimal('annual_revenue', 15, 2)->nullable();
            $table->string('company_size', 20)->nullable();

            //Meta fields
            $table->uuid('owner_id')->nullable();
            $table->text('logo_url')->nullable();
            $table->string('timezone', 50)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('owner_id')->references('id')->on('users');

            //Indexes
            $table->index(['name'], 'idx_companies_name');
            $table->index(['owner_id'], 'idx_companies_owner');
            $table->index(['industry'], 'idx_companies_industry');



            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
