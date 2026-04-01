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
        Schema::table('billings', function (Blueprint $table) {
            $table->tinyInteger('discount')->default(0)->after('tax')->comment('discount percentage (0-100)');
            $table->decimal('discamt', 10, 2)->default(0)->after('discount')->comment('discount amount in RM');
        });

        Schema::table('ledger_managers', function (Blueprint $table) {
            $table->decimal('discount', 12, 2)->default(0)->after('tax')->comment('total discount amount for period');
        });

        Schema::table('restros', function (Blueprint $table) {
            $table->tinyInteger('discount')->default(0)->after('rest')->comment('default discount percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->dropColumn(['discount', 'discamt']);
        });

        Schema::table('ledger_managers', function (Blueprint $table) {
            $table->dropColumn('discount');
        });

        Schema::table('restros', function (Blueprint $table) {
            $table->dropColumn('discount');
        });
    }
};
