<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('restros', function (Blueprint $table) {
            $table->string('cred_password')->nullable()->after('addr');
        });

        $defaultPlain = 'Admin@123';

        foreach (DB::table('restros')->orderBy('id')->get() as $row) {
            DB::table('restros')->where('id', $row->id)->update([
                'cred_password' => bcrypt($defaultPlain),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restros', function (Blueprint $table) {
            $table->dropColumn('cred_password');
        });
    }
};
