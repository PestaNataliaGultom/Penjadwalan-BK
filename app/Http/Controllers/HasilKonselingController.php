<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HasilKonseling; // Ini sepertinya tidak terpakai jika Anda pakai ScheduleOutput
use App\Models\Schedule;
use App\Models\ScheduleOutput;
use App\Models\Siswa; // Ini sepertinya tidak terpakai jika Anda pakai user relasi
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // Import Log facade untuk debugging
use Illuminate\Support\Facades\Auth;

class HasilKonselingController extends Controller
{
    public function index()
    {
       $schedules = Schedule::with(['user', 'outputSchedule'])->where('teacher_id', Auth::user()->id)->where('status', 1)
                            ->has('user')
                            ->orderBy('schedule_date')
                             ->orderBy('duration')
                            ->get();
        return view('guru.hasil', compact('schedules'));
    }

    public function create()
    {
        return view('guru.hasil_konseling.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required',
            'jenis_masalah' => 'required',
            'deskripsi_masalah' => 'required',
            'solusi' => 'required',
        ]);

        // Sebaiknya gunakan updateOrCreate jika Anda ingin satu hasil per jadwal
        // $hasil = ScheduleOutput::updateOrCreate(
        //     ['schedule_id' => $request->schedule_id],
        //     [
        //         'category' => $request->jenis_masalah,
        //         'description' => $request->deskripsi_masalah,
        //         'solution' => $request->solusi,
        //     ]
        // );

        // Jika Anda memang ingin selalu membuat baru setiap kali store dipanggil:
        $hasil = new ScheduleOutput();
        $hasil->schedule_id = $request->schedule_id;
        $hasil->category = $request->jenis_masalah;
        $hasil->description = $request->deskripsi_masalah;
        $hasil->solution = $request->solusi;
        $hasil->save();

        return redirect()->route('guru.hasil-konseling')->with('success', 'Hasil konseling berhasil disimpan');
    }

    /**
     * Menampilkan detail hasil konseling untuk jadwal tertentu.
     *
     * @param  int  $id  ID dari jadwal (schedule_id)
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $schedule = Schedule::with(['user', 'outputSchedule'])
                            ->where('id', $id)
                            ->where('teacher_id', Auth::user()->id)
                            ->first(); // <-- Tambahkan ->first() di sini!

        // Jika jadwal tidak ditemukan atau tidak memiliki guru yang sesuai
        if (!$schedule) {
            return redirect()->route('guru.hasil-konseling')->with('error', 'Jadwal konseling tidak ditemukan atau Anda tidak memiliki akses.');
        }

        // Mengambil hasil konseling yang terkait dengan jadwal ini.
        $hasilKonseling = $schedule->outputSchedule;

        // Jika tidak ada hasil konseling yang terkait dengan jadwal ini
        if (!$hasilKonseling) {
            // Mengarahkan kembali dengan pesan warning dan ID jadwal untuk form create
            return redirect()->route('guru.hasil-konseling')->with('warning', 'Belum ada hasil konseling yang dicatat untuk jadwal ini.')->with('scheduleIdToCreate', $id);
        }

        // Jika hasil konseling ditemukan, tampilkan view detail
        return view('guru.hasil_konseling.show', compact('schedule', 'hasilKonseling'));
    }
}