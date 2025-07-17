<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilKonseling extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_siswa',
        'nisn',
        'kelas',
        'jurusan',
        'alamat',
        'no_handphone',
        'jadwal',
        'tanggal',
        'jenis_masalah',
        'deskripsi_masalah',
        'solusi_masalah',
    ];
}
