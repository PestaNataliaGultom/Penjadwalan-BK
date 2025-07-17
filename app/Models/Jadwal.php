<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwals';

    protected $fillable = [
        'tanggal',
        'jam',
        'keterangan',
        'siswa_id', // 
        'guru_id',  // jika ada relasi ke guru
    ];

    // Relasi ke model Siswa (jika kamu punya model Siswa)
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi ke model User sebagai guru (jika diperlukan)
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
