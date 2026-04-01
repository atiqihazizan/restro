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
        Schema::create('ledger_managers', function (Blueprint $table) {
            $table->id();
            $table->string('dmy',25)->nullable()->comment('Ref for date or yearmonth or year');
            $table->decimal('subtotal',12,2)->default(0);
            $table->decimal('tax',12,2)->default(0);
            $table->decimal('total',12,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledger_managers');
    }
};
