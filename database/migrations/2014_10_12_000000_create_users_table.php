<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('nis')->nullable(); // untuk siswa
            $table->string('nip')->nullable(); // untuk guru dan admin
            $table->string('kelas')->nullable(); // untuk siswa
            $table->string('jurusan')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('alamat')->nullable(); // untuk siswa
            $table->string('nomor_handphone')->nullable(); // untuk siswa
            $table->boolean('is_active')->default(true);
            $table->integer('capacity')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
