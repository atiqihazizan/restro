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
        Schema::dropIfExists('dailies');
        Schema::dropIfExists('monthlies');
        Schema::dropIfExists('yearlies');
        Schema::dropIfExists('daily_food');
        Schema::dropIfExists('monthly_food');
        Schema::dropIfExists('yearly_food');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('dailies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
        
        Schema::create('monthlies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
        
        Schema::create('yearlies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
        
        Schema::create('daily_food', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cate_id');
            $table->string('cate_name');
            $table->timestamps();
        });
        
        Schema::create('monthly_food', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
        
        Schema::create('yearly_food', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
};
