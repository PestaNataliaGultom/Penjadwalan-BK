<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = User::whereHas('roles', function($q){
            $q->where('name', 'Siswa');
        })->count();

        $konselingAktif = 0;
        $totalJadwalHariIni = 0;
        $jadwalHariIni = collect();

        $totalGuruBK = User::whereHas('roles', function($q){
            $q->where('name', 'Guru Bk');
        })->count();
        $konselingTerbaru = collect();
        
        return view('admin.dashboard', compact('totalSiswa','konselingAktif', 'totalJadwalHariIni', 'jadwalHariIni', 'totalGuruBK', 'konselingTerbaru'));
    }
    

}