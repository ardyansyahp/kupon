<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->unsignedSmallInteger('qty_ambil')->default(1)->after('status');
            $table->boolean('is_walkin')->default(false)->after('qty_ambil');
        });
    }

    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->dropColumn(['qty_ambil', 'is_walkin']);
        });
    }
};
