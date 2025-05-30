<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('color', 7)->default('#3B82F6');
            $table->text('description')->nullable();
            $table->string('tag_type', 20)->default('general');
            $table->timestamps();
        });

        // Insert default tags
        DB::table('tags')->insert([
            ['name' => 'Hot Lead', 'color' => '#EF4444', 'tag_type' => 'lead_status', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'VIP Customer', 'color' => '#8B5CF6', 'tag_type' => 'customer_type', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Enterprise', 'color' => '#10B981', 'tag_type' => 'company_size', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Follow Up', 'color' => '#F59E0B', 'tag_type' => 'action_required', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Small Business', 'color' => '#6B7280', 'tag_type' => 'company_size', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
