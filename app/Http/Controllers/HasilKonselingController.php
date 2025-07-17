<?php

namespace App\Http\Controllers;

use App\Models\HasilKonseling;
use Illuminate\Http\Request;

class HasilKonselingController extends Controller
{
    public function index()
    {
        $hasil = HasilKonseling::latest()->get();
        return view('guru.create', compact('hasil'));
    }

    public function create()
    {
        return view('guru.hasil.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'nisn' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'alamat' => 'required',
            'no_handphone' => 'required',
            'tanggal' => 'required|date',
            'jadwal' => 'nullable',
            'jenis_masalah' => 'required',
            'deskripsi_masalah' => 'required',
            'solusi_masalah' => 'required',
        ]);

        HasilKonseling::create($request->all());

        return redirect()->route('HasilKonseling')->with('success', 'Hasil konseling berhasil disimpan.');
    }
}
