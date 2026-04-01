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
        Schema::create('ledger_food', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cate_id');
            $table->foreignId('man_id')->default();
            $table->integer('qty')->default(0);
            $table->tinyInteger('sts')->default(0)->comment('1:debit 2:credit');
            $table->decimal('amount',10,2)->default(0);
            $table->decimal('tax',10,2)->default(0);
            $table->decimal('netamt',10,2)->default(0);
            $table->date('dtsale')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledger_food');
    }
};
