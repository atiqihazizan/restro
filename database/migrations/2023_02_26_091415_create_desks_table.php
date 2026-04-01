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
        Schema::create('desks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->default(0);
            $table->tinyInteger('sts')->default(0)->comment('sts = 0: no order 1:pre-order 2:confirm/pay 3:cooking 4:ready delivery 5:done');
            $table->tinyInteger('odrcnt')->default(0);
            $table->tinyInteger('odrtyp')->default(1);
            $table->dateTime('odrtm')->nullable();
            $table->string('name',30);
            $table->string('code',20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desks');
    }
};
