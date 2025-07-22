<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HasilKonseling;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // Import Log facade untuk debugging
use Illuminate\Support\Facades\Auth;

class HasilKonselingController extends Controller
{
    public function index()
    {
        // Jika model HasilKonseling menggunakan SoftDeletes,
        // HasilKonseling::latest()->get() secara default hanya akan mengambil data yang belum di-soft delete.
        $data = HasilKonseling::latest()->get();
        return view('guru.hasil', compact('data'));
    }

    public function create()
    {
        return view('guru.hasil_konseling.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_siswa' => 'required|string',
            'nisn' => 'required|string',
            'kelas' => 'required|string',
            'jurusan' => 'required|string',
            'alamat' => 'required|string',
            'no_handphone' => 'required|string',
            'jadwal' => 'required|string',
            'tanggal' => 'required|date',
            'jenis_masalah' => 'required|string',
            'deskripsi_masalah' => 'required|string',
            'solusi_masalah' => 'required|string',
        ]);

        $siswa = Siswa::where('nisn', $request->nisn)->first();

        // Jika siswa tidak ditemukan, kembalikan dengan pesan error
        if (!$siswa) {
            return back()->withInput()->with('error', 'Siswa dengan NISN tersebut tidak ditemukan. Pastikan siswa sudah terdaftar.');
        }

        // 2. Dapatkan ID Guru BK yang sedang login
        $guruBkId = Auth::id(); // Menggunakan facade Auth untuk mendapatkan ID user yang sedang login

        // 3. Buat instance baru dari HasilKonseling
        $hasilKonseling = new HasilKonseling();

        // 4. Isi foreign keys (siswa_id dan guru_bk_id)
        $hasilKonseling->siswa_id = $siswa->id; // Isi dengan ID siswa yang ditemukan
        $hasilKonseling->guru_bk_id = $guruBkId; // Isi dengan ID Guru BK yang login

        // 5. Isi kolom-kolom lain dari data yang divalidasi
        // Anda bisa mengisi satu per satu seperti ini:
        $hasilKonseling->nama_siswa = $validated['nama_siswa'];
        $hasilKonseling->nisn = $validated['nisn'];
        $hasilKonseling->kelas = $validated['kelas'];
        $hasilKonseling->jurusan = $validated['jurusan'];
        $hasilKonseling->alamat = $validated['alamat'];
        $hasilKonseling->no_handphone = $validated['no_handphone'];
        $hasilKonseling->jadwal = $validated['jadwal'];
        $hasilKonseling->tanggal = $validated['tanggal'];
        $hasilKonseling->jenis_masalah = $validated['jenis_masalah'];
        $hasilKonseling->deskripsi_masalah = $validated['deskripsi_masalah'];
        $hasilKonseling->solusi_masalah = $validated['solusi_masalah'];

        // 6. Simpan data ke database
        $hasilKonseling->save();

        // --- AKHIR PENGGANTIAN KODE ---

        // Pastikan nama rute ini konsisten dengan rute index Anda
        return redirect()->route('guru.hasil-konseling')->with('success', 'Data hasil konseling berhasil disimpan.');
    }

    public function edit(HasilKonseling $hasilKonseling)
    {
        return view('guru.hasilkonseling.edit', compact('hasilKonseling'));
    }

    public function update(Request $request, HasilKonseling $hasilKonseling)
    {
        // Perbaiki nama field validasi agar sesuai dengan nama kolom di database/model
        $validatedData = $request->validate([
            'nama_siswa' => 'required|string', // Perbaiki dari 'nama'
            'nisn' => 'required|string',
            'kelas' => 'required|string',
            'jurusan' => 'required|string',
            'alamat' => 'required|string',
            'no_handphone' => 'required|string', // Tambahkan jika ada di form edit
            'jadwal' => 'required|date_format:H:i',// Tambahkan jika ada di form edit
            'tanggal' => 'required|date',
            'jenis_masalah' => 'required|string', // Perbaiki dari 'jenis_masalah'
            'deskripsi_masalah' => 'required|string', // Perbaiki dari 'deskripsi'
            'solusi_masalah' => 'required|string', // Perbaiki dari 'solusi'
        ]);

        $hasilKonseling->update($validatedData);
        
        // Perbaiki nama rute redirect agar konsisten dengan rute index Anda
        return redirect()->route('guru.hasil-konseling')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id) // Ubah dari HasilKonseling $hasilKonseling menjadi $id
    {
        try {
            Log::info("Attempting to delete HasilKonseling with ID: " . $id);

            // Gunakan find() daripada findOrFail() untuk penanganan error yang lebih lembut
            $hasilKonseling = HasilKonseling::find($id); 

            if (!$hasilKonseling) {
                Log::warning("HasilKonseling with ID: " . $id . " not found for deletion.");
                return redirect()->route('guru.hasil-konseling')->with('error', 'Data tidak ditemukan.');
            }

            // --- Bagian Penting untuk Soft Deletes ---
            // Cek apakah model HasilKonseling menggunakan SoftDeletes trait
            // Jika Anda ingin menghapus permanen meskipun model menggunakan SoftDeletes, gunakan forceDelete()
            if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(HasilKonseling::class))) {
                Log::info("Model HasilKonseling uses SoftDeletes. Attempting soft delete for ID: " . $id);
                $hasilKonseling->delete(); // Ini akan mengisi kolom `deleted_at`
                // Jika ingin menghapus permanen, uncomment baris di bawah ini dan comment baris di atasnya:
                // $hasilKonseling->forceDelete();
            } else {
                Log::info("Model HasilKonseling does not use SoftDeletes. Attempting hard delete for ID: " . $id);
                $hasilKonseling->delete(); // Ini akan menghapus permanen dari database
            }

            Log::info("HasilKonseling with ID: " . $id . " successfully deleted (or soft-deleted).");
            return redirect()->route('guru.hasil-konseling')->with('success', 'Data berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error("Error deleting HasilKonseling with ID: " . $id . ". Error: " . $e->getMessage());
            return redirect()->route('guru.hasil-konseling')->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
