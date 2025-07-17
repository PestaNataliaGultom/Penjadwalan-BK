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
        Schema::create('hasil_konselings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_siswa');
            $table->string('nisn');
            $table->string('kelas');
            $table->string('jurusan');
            $table->text('alamat');
            $table->string('no_handphone');
            $table->date('tanggal');
            $table->time('jadwal')->nullable();
            $table->string('jenis_masalah');
            $table->text('deskripsi_masalah');
            $table->text('solusi_masalah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_konselings');
    }
};
