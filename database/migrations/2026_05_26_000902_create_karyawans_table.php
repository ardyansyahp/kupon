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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('nama');
            $table->string('departemen');
            $table->string('plant');
            $table->string('jeniskelamin')->nullable();
            $table->string('status')->nullable();
            $table->enum('status_tukar', ['belum', 'menunggu', 'sudah', 'ditolak'])->default('belum');
            $table->timestamp('waktu_tukar')->nullable();
            $table->timestamp('waktu_konfirmasi')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
