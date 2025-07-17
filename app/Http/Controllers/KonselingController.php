<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KonselingController extends Controller
{
    public function index()
    {
        // Statistik konseling
        $statistik = [
            'konseling_aktif' => 24,
            'konseling_individu' => 18,
            'konseling_kelompok' => 6,
            'menunggu_jadwal' => 3
        ];
        
        // Permintaan konseling baru
        $permintaanBaru = [
            [
                'id' => 1,
                'nama_siswa' => 'Dewi Sartika',
                'kelas' => 'XII IPA 2',
                'jenis_masalah' => 'Stres Ujian',
                'tanggal_pengajuan' => '8 Jun 2025',
                'prioritas' => 'Tinggi',
                'status' => 'Menunggu'
            ],
            [
                'id' => 2,
                'nama_siswa' => 'Randi Pratama',
                'kelas' => 'XI IPS 1',
                'jenis_masalah' => 'Masalah Sosial',
                'tanggal_pengajuan' => '7 Jun 2025',
                'prioritas' => 'Sedang',
                'status' => 'Menunggu'
            ],
            [
                'id' => 3,
                'nama_siswa' => 'Lisa Maharani',
                'kelas' => 'X MIPA 3',
                'jenis_masalah' => 'Motivasi Belajar',
                'tanggal_pengajuan' => '6 Jun 2025',
                'prioritas' => 'Rendah',
                'status' => 'Menunggu'
            ]
        ];
        
        // Konseling aktif
        $konselingAktif = [
            [
                'id' => 1,
                'nama_siswa' => 'Ahmad Rizki',
                'kelas' => 'XI IPA 1',
                'jenis_konseling' => 'Individu',
                'masalah' => 'Kesulitan Belajar',
                'tanggal_mulai' => '8 Jun 2025',
                'status' => 'Berlangsung',
                'sesi_ke' => 2
            ],
            [
                'id' => 2,
                'nama_siswa' => 'Kelompok Sosial A',
                'kelas' => 'X IPS 2',
                'jenis_konseling' => 'Kelompok',
                'masalah' => 'Konflik Antar Teman',
                'tanggal_mulai' => '7 Jun 2025',
                'status' => 'Berlangsung',
                'sesi_ke' => 1
            ]
        ];
        
        return view('guru.konseling.index', compact('statistik', 'permintaanBaru', 'konselingAktif'));
    }
    
    public function create()
    {
        // Data untuk form create konseling
        $siswa = [
            ['id' => 1, 'nama' => 'Ahmad Rizki', 'kelas' => 'XI IPA 1'],
            ['id' => 2, 'nama' => 'Siti Nurhaliza', 'kelas' => 'XII IPS 1'],
            ['id' => 3, 'nama' => 'Budi Santoso', 'kelas' => 'X MIPA 2']
        ];
        
        return view('guru.konseling.create', compact('siswa'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'jenis_konseling' => 'required|in:individu,kelompok',
            'jenis_masalah' => 'required|string|max:255',
            'deskripsi_masalah' => 'required|string',
            'tanggal_konseling' => 'required|date',
            'prioritas' => 'required|in:rendah,sedang,tinggi'
        ]);
        
        // Simpan ke database
        // Konseling::create($request->all());
        
        return redirect()->route('guru.konseling')->with('success', 'Sesi konseling berhasil dibuat!');
    }
    
    public function show($id)
    {
        // Detail konseling
        $konseling = [
            'id' => $id,
            'nama_siswa' => 'Ahmad Rizki',
            'kelas' => 'XI IPA 1',
            'jenis_konseling' => 'Individu',
            'masalah' => 'Kesulitan Belajar',
            'deskripsi' => 'Siswa mengalami kesulitan dalam memahami mata pelajaran matematika dan fisika.',
            'tanggal_mulai' => '8 Jun 2025',
            'status' => 'Berlangsung',
            'sesi_ke' => 2,
            'catatan_sesi' => [
                [
                    'sesi' => 1,
                    'tanggal' => '8 Jun 2025',
                    'catatan' => 'Sesi pertama, identifikasi masalah utama.',
                    'tindak_lanjut' => 'Berikan latihan soal tambahan.'
                ]
            ]
        ];
        
        return view('guru.konseling.show', compact('konseling'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:berlangsung,selesai,dibatalkan',
            'catatan' => 'nullable|string'
        ]);
        
        // Update status di database
        // Konseling::where('id', $id)->update(['status' => $request->status, 'catatan' => $request->catatan]);
        
        return redirect()->route('guru.konseling')->with('success', 'Status konseling berhasil diperbarui!');
    }
}