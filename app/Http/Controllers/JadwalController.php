<?php

namespace App\Http\Controllers;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;

class JadwalController extends Controller
{
    public function index()
    {
        $guru = User::whereHas('roles', function($q){
            $q->where('name', 'Guru Bk');
        })->get();
        return view('guru.jadwal', compact('guru'));
    }

    public function getTotalJadwal(Request $request)
    {
        $schedules = Schedule::orderBy('schedule_date')->get();

        $groupedSchedules = $schedules->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->schedule_date)->format('Y-m-d');
        });


        $calendarEvents = [];

        foreach ($groupedSchedules as $date => $details) {
            $sortedDetails = $details->sortBy('duration');
            $calendarEvents[] = [
                'title' => $sortedDetails->count() . ' Jadwal', 
                'date' => $date,
                'allDay' => true,
                'extendedProps' => [
                    'details' => $sortedDetails->map(function($schedule) {
                        return [
                            'id' => $schedule->id,
                            'student_name' => $schedule->user?->name,
                            'kelas_name' => $schedule->user?->kelas,
                            'jurusan_name' => $schedule->user?->jurusan,
                            'duration'     => $schedule->duration,
                            'status_badge'     => $schedule->status_badge,
                            'status'     => $schedule->status,
                            'description'     => $schedule->notes,
                        ];
                    })->values()->toArray()
                ]
            ];
        }

        return response()->json($calendarEvents);
    }


    public function approve(Request $request){
        $schedule = Schedule::find($request->id);
        
        if(!$schedule){
            return response()->json(['status' => false], 404);
        }


        if ($schedule->status == 1) {
            return response()->json([
                'status' => false, 
                'message' => 'Jadwal ini sudah disetujui sebelumnya.'
            ], 409);
        }
       
        $date = $schedule->schedule_date;
        $duration = (int) $schedule->duration;

        $lastApprovedSchedule = Schedule::whereDate('schedule_date', $date)
            ->where('status', 1)
            ->orderBy('to_time', 'desc')
            ->first();
        
        if ($lastApprovedSchedule) {
            $newFromTime = Carbon::parse($lastApprovedSchedule->to_time);
        } else {
            $newFromTime = Carbon::parse($date . ' 09:00:00');
        }

        $newToTime = $newFromTime->copy()->addMinutes($duration);
        $dayEndTime = Carbon::parse($date . ' 12:00:00');
        if ($newToTime->gt($dayEndTime)) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal, slot waktu sudah penuh atau melebihi jam kerja (12:00).'
            ], 422);
        }

        $schedule->update([
            'status' => 1,
            'from_time' => $newFromTime->format('H:i:s'),
            'to_time' => $newToTime->format('H:i:s'),
        ]);

        if ($schedule->teacher) {
            $schedule->teacher->decrement('capacity');
        }
        if ($schedule->user) {
            $schedule->user->decrement('capacity');
        }

        return response()->json(['status' => true, 'message' => 'Jadwal berhasil disetujui dan dijadwalkan pada jam ' . $newFromTime->format('H:i') . '.'], 200);
    }


}
