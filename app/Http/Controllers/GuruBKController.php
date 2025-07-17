<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Schedule;

class GuruBKController extends Controller
{
    public function dashboard()
    {
        $totalSiswa = User::whereHas('roles', function($q){
            $q->where('name', 'Siswa');
        })->count();

        $totalKonseling = Schedule::with('user')->where('teacher_id', Auth::user()->id)->count();

        $totalGuruBK = User::whereHas('roles', function($q){
            $q->where('name', 'Guru Bk');
        })->count();

        $konselingTerbaru =Schedule::with('user')->limit(5)->orderBy('to_time')->get();

        $guru = User::whereHas('roles', function($q){
            $q->where('name', 'Guru Bk');
        })->get();

        $schedules = Schedule::with('user')->whereDate('schedule_date', now()->format('Y-m-d'))->get();

        return view('guru.dashboard', compact(
            'totalSiswa',
            'totalGuruBK',
            'konselingTerbaru',
            'totalKonseling',
            'guru',
            'schedules'
            
        ));
    }    
}