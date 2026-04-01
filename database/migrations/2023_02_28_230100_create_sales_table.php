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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issue_id')->default(0);
            $table->foreignId('bill_id')->default(0);
            $table->foreignId('cate_id')->default(0);
            $table->foreignId('food_id')->default(0);
            $table->tinyInteger('qty')->default(0);
            $table->decimal('price',10,2)->default(0);
            $table->decimal('tax',10,2)->default(0);
            $table->decimal('amount',10,2)->default(0);
            $table->datetime('print')->nullable()->comment('mudah untuk re-print balik');
            $table->string('name')->nullable();
            $table->json('addon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
