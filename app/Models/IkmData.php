<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IkmData extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_usaha',
        'nib',
        'nama_pemilik',
        'alamat_pemilik',
        'alamat_usaha',
        'kapasitas_bulan',
        'kapasitas_tahun',
        'halal',
        'pirt',
        'bpom',
        'bidang_usaha'
    ];
}
