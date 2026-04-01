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
        Schema::create('restros', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('gst')->default(0);
            $table->tinyInteger('sst')->default(0);
            $table->tinyInteger('rest')->default(0)->comment('restro tax');
            $table->boolean('ordersts')->default(1);
            $table->boolean('paysts')->default(0);
            $table->tinyInteger('oseq')->default(0)->comment('order sequence');
            $table->tinyInteger('rseq')->default(0)->comment('receipt sequence');
            $table->tinyInteger('iseq')->default(0)->comment('invoice sequence');
            $table->tinyInteger('qseq')->default(0)->comment('quotation sequence');
            $table->string('gst_reg',30)->nullable();
            $table->string('sst_reg',30)->nullable();
            $table->string('logotxt',20)->nullable();
            $table->string('logoimg',70)->nullable();
            $table->string('name',150)->nullable();
            $table->string('tel',15)->nullable();
            $table->string('fax',15)->nullable();
            $table->tinyText('addr')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restros');
    }
};
