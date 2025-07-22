<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilKonseling extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'guru_bk_id',
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

     public function siswa()
    {
        // Mendefinisikan relasi Many-to-One: HasilKonseling ini dimiliki oleh satu Siswa.
        // 'siswa_id' adalah foreign key di tabel 'hasil_konselings' yang merujuk ke 'id' di tabel 'siswas'.
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
    public function guruBk()
    {
        // Mendefinisikan relasi Many-to-One: HasilKonseling ini diinput oleh satu User (Guru BK).
        // 'guru_bk_id' adalah foreign key di tabel 'hasil_konselings' yang merujuk ke 'id' di tabel 'users'.
        return $this->belongsTo(User::class, 'guru_bk_id');
    }
}
