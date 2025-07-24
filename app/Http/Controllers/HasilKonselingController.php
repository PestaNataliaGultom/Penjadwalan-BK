<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HasilKonseling;
use App\Models\Schedule;
use App\Models\ScheduleOutput;
use App\Models\Siswa;
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

        $hasil = new ScheduleOutput();
        $hasil->schedule_id = $request->schedule_id;
        $hasil->category = $request->jenis_masalah;
        $hasil->description = $request->deskripsi_masalah;
        $hasil->solution = $request->solusi;
        $hasil->save();

        return redirect()->route('guru.hasil-konseling')->with('success', 'Hasil konseling berhasil disimpan');
    }
}
