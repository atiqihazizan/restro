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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issue_id')->default(0)->comment('user take order');
            $table->foreignId('closed_id')->default(0)->comment('user receive payment');
            $table->foreignId('desk_id')->default(0);
            $table->tinyInteger('order_cnt')->default(0);
            $table->tinyInteger('paidtype')->default(1)->comment('1:cash 2:credit');
            $table->tinyInteger('tax')->default(0)->comment('tax number');
            $table->decimal('subtotal',10,2)->default(0);
            $table->decimal('gst',10,2)->default(0)->comment('GST Tax');
            $table->decimal('sst',10,2)->default(0)->comment('SST Tax');
            $table->decimal('rest',10,2)->default(0)->comment('Restro tax');
            $table->decimal('grandtotal',10,2)->default(0);
            $table->decimal('paid',10,2)->default(0);
            $table->decimal('change',10,2)->default(0);
            $table->datetime('paid_at')->nullable();
            $table->string('rcptno',15)->nullable();
            $table->string('orderno',15)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
