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
         Schema::table('model_has_roles', function (Blueprint $table) {
            $table->dropPrimary();
            $table->dropColumn('model_id');
        });

        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->uuid('model_id');
            $table->primary(['role_id', 'model_id', 'model_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('model_has_roles', function (Blueprint $table) {
            $table->dropPrimary();
            $table->dropColumn('model_id');
        });

        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('model_id');
            $table->primary(['role_id', 'model_id', 'model_type']);
        });
    }
};
