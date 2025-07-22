<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Schedule;
use App\Models\HasilKonseling;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
     /**
     * Halaman dashboard untuk siswa
     */
    public function dashboard()
    {
        $totalGuru = User::whereHas('roles', function($q){
            $q->where('name', 'Guru Bk');
        })->count(); 

        $totalSchedule = Schedule::where('user_id', Auth::user()->id)->count();
        $totalScheduleToday = Schedule::where('user_id', Auth::user()->id)
        ->whereDate('schedule_date', now()->format('Y-m-d'))
        ->count();

        return view('siswa.dashboard', compact('totalGuru','totalSchedule', 'totalScheduleToday'));
    }

    /**
     * Halaman dashboard untuk siswa
     */
    public function jadwal()
    {
        $totalGuru = User::whereHas('roles', function($q){
            $q->where('name', 'Guru Bk');
        })->count(); 

        $guru = User::whereHas('roles', function($q){
            $q->where('name', 'Guru Bk');
        })->get(); 

        $schedules = Schedule::with(['user','teacher'])->where('user_id', Auth::id())->get();
      
        return view('siswa.jadwal', compact('totalGuru','guru'));
    }

    public function jadwalPost(Request $request)
    {
        try {
            DB::beginTransaction();

            // Format tanggal
            $originalDate = $request->schedule_date;
            $bulanIndonesia = [
                'Januari' => 'January', 'Februari' => 'February', 'Maret' => 'March',
                'April' => 'April', 'Mei' => 'May', 'Juni' => 'June',
                'Juli' => 'July', 'Agustus' => 'August', 'September' => 'September',
                'Oktober' => 'October', 'November' => 'November', 'Desember' => 'December',
            ];
            $cleanedDate = preg_replace('/^[A-Za-z]+,\s*/', '', $originalDate);
            foreach ($bulanIndonesia as $indo => $eng) {
                if (strpos($cleanedDate, $indo) !== false) {
                    $cleanedDate = str_replace($indo, $eng, $cleanedDate);
                    break;
                }
            }
            $formattedDate = Carbon::createFromFormat('d F Y', $cleanedDate)->format('Y-m-d');
            
            if(empty(Auth::user()->capacity)){
                return redirect()->back()->with('error', 'Data Kapasitas Siswa Masih 0');
            }


            $scheduleExist = Schedule::whereDate('schedule_date', $formattedDate)->where('user_id', Auth::id())->first();

            $totalSchedule = Schedule::whereDate('schedule_date', $formattedDate)->where('teacher_id', $request->guru)->get()->count();
            
            $capacityTeacher = User::find($request->guru);
            if($capacityTeacher->capacity == 0){
                return redirect()->back()->with('error', 'Guru BK tidak mempunyai Kapasitas Konseling');
            }

            if($totalSchedule >= $capacityTeacher->capacity){
                return redirect()->back()->with('error', 'Data Jadwal Sudah melebihi Maksimal, Anda Tidak bisa membuat jadwal lagi');
            }

            if($scheduleExist){
                return redirect()->back()->with('error', 'Data Jadwal Hari ini sudah ada, Tidak Boleh di tanggal yang sama !!');
            }

            // Hitung durasi minimal 1 jam
            // $from = Carbon::createFromFormat('H:i', $request->from_time);
            // $to = Carbon::createFromFormat('H:i', $request->to_time);
            // $durasiMenit = max(1, $to->diffInMinutes($from)); // Minimal 1 menit

            // // Waktu kerja
            // $mulai = Carbon::createFromTime(9, 0); // Jam kerja mulai
            // $batas = Carbon::createFromTime(17, 0); // Jam kerja selesai
            // $jamIstirahatMulai = Carbon::createFromTime(12, 0);
            // $jamIstirahatSelesai = Carbon::createFromTime(13, 0);

            // $interval = 5; // interval pencarian slot dalam menit

            // while ($mulai->copy()->addMinutes($durasiMenit)->lte($batas)) {
            //     $selesai = $mulai->copy()->addMinutes($durasiMenit);

            //     // Lewati jam istirahat
            //     if (
            //         $mulai->between($jamIstirahatMulai, $jamIstirahatSelesai) ||
            //         $selesai->between($jamIstirahatMulai, $jamIstirahatSelesai)
            //     ) {
            //         $mulai->addMinutes($interval);
            //         continue;
            //     }

                // SIMPAN ke database
            Schedule::create([
                'user_id' => Auth::id(),
                'teacher_id' => $request->guru,
                'schedule_date' => $formattedDate,
                'duration' => $request->duration,
                'notes' => $request->ketarangan,
            ]);


            DB::commit();
            return redirect()->back()->with('success', 'Data Penjadwalan Berhasil dibuat');
            // }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menjadwalkan.');
        }
    }

    public function getSchedules()
    {
        $schedules = Schedule::with(['user', 'teacher'])->where('user_id', Auth::id())->get();

        $events = $schedules->map(function ($schedule) {
            return [
                'title' => 'Konseling: ' . $schedule->user->name,
                'start' => $schedule->schedule_date,
                'extendedProps' => [
                    'siswa' => $schedule->user->name,
                    'guru' => $schedule->teacher->name ?? '-',
                    'duration' => $schedule->duration,
                    'deskripsi' => $schedule->notes ?? '-',
                    'from_time' => $schedule->from_time ?? '-',
                    'to_time' => $schedule->to_time ?? '-',
                    'status_badge' => $schedule->status_badge ?? '-',
                ]
            ];
        });

        return response()->json($events);
    }

    public function hasilKonseling()
    {
        // Pastikan siswa sudah login
        if (!Auth::check()) {
            // Jika tidak login, arahkan ke halaman login siswa
            return redirect()->route('login.siswa')->with('error', 'Anda harus login sebagai siswa untuk melihat hasil konseling.');
        }

        // Ambil NISN dari siswa yang sedang login
        // Asumsi: Model User siswa memiliki kolom 'nisn'
        $user = Auth::user();
        $siswa = $user->siswa;
        if (!$siswa) {
             return view('siswa.hasil', ['data' => collect()])->with('message', 'Data siswa Anda tidak ditemukan atau belum ada hasil konseling.');
    }
        // Ambil data hasil konseling berdasarkan siswa_id dari siswa yang login
       $data = HasilKonseling::where('siswa_id', $siswa->id)->latest()->get();

        // Kirim data ke view siswa.hasil
        return view('siswa.hasil', compact('data'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswas = Siswa::latest()->paginate(10);
        return view('siswa.index', compact('siswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('siswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama'     => 'required',
            'nisn'     => 'required',
            'kelas'    => 'required',
            'jurusan'  => 'required',
            'email'    => 'required',
            'alamat'   => 'required',
            'no_hp'    => 'required',
            'password' => 'required',
        ], [
            'nama.required'     => 'Nama lengkap wajib diisi.',
            'nisn.required'     => 'NISN wajib diisi.',
            'nisn.unique'       => 'NISN sudah terdaftar.',
            'kelas.required'    => 'Kelas wajib diisi.',
            'jurusan.required'  => 'Jurusan wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar.',
            'alamat.required'   => 'Alamat wajib diisi.',
            'no_hp.required'    => 'Nomor HP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        try {
            $validatedData['password'] = Hash::make($validatedData['password']);
            Siswa::create($validatedData);

            return redirect('/siswa')->with('success', 'Data siswa berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        return view('siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        return view('siswa.edit', compact('siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $validatedData = $request->validate([
            'nama'     => 'required|string|max:255',
            'nisn'     => ['required', 'string', 'max:20', Rule::unique('siswas')->ignore($siswa->id)],
            'kelas'    => 'required|string|max:50',
            'jurusan'  => 'required|string|max:100',
            'email'    => ['required', 'email', 'max:255', Rule::unique('siswas')->ignore($siswa->id)],
            'alamat'   => 'required|string',
            'no_hp'    => 'required|string|max:20',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:6',
            ]);
            $validatedData['password'] = Hash::make($request->password);
        }

        try {
            $siswa->update($validatedData);
            return redirect('/siswa')->with('success', 'Data siswa berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        try {
            $siswa->delete();
            return redirect('/siswa')->with('success', 'Data siswa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
