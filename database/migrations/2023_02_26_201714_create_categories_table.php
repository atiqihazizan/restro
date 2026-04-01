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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('subname',150)->nullable();
            $table->tinyInteger('type')->default(0)->comment('0:all 1:food 2:drink');
            $table->dateTime('endsales')->nullable()->comment('last sales utk semak product masih active');
            $table->binary('icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
