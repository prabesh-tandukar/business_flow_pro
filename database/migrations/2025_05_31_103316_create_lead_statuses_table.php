<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lead_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_converted')->default(false);
            $table->integer('display_order')->default(0);
            $table->string('color', 7)->default('#6B7280');
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('lead_statuses');
    }
};