<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('deal_stages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->text('description')->nullable();
            $table->decimal('probability', 5, 2)->default(0.00)->comment('0.00-100.00 percentage');
            $table->integer('display_order')->default(0);
            $table->boolean('is_closed')->default(false);
            $table->boolean('is_won')->default(false);
            $table->string('color', 7)->default('#6B7280');
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('deal_stages');
    }
};