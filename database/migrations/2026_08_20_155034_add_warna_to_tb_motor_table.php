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
        Schema::table('tb_motor', function (Blueprint $table) {
            $table->string('warna',50)->nullable()->after('nama_motor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_motor', function (Blueprint $table) {
            $table->dropColumn('warna');
        });
    }
};
