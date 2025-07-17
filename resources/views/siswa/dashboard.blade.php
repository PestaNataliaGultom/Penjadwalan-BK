@extends('siswa.app')

@section('title', 'Dashboard Siswa')

@section('content')  
<div class="container-fluid">
    <div class="content-header d-flex justify-content-between">
        <h1>Dashboard {{Auth::user()->roles->pluck('name')[0] ?? "-"}}</h1>
        <h4>Kapasitas : {{Auth::user()->capacity}}</h4>
    </div>
    <div class="alert alert-info" role="alert">
        <h4 class="mb-0">Halo! Selamat Datang {{ Auth::user()->name }}!</h4>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card dashboard-card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Konseling Aktif</h5>
                            <h2 class="mb-0">{{$totalSchedule}}</h2>
                        </div>
                        <div class="card-icon bg-light text-success rounded">
                            <i class="fas fa-comments"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Jadwal Hari Ini</h5>
                            <h2 class="mb-0">{{$totalScheduleToday}}</h2>
                        </div>
                        <div class="card-icon bg-light text-warning rounded">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Guru BK</h5>
                            <h2 class="mb-0">{{$totalGuru}}</h2>
                        </div>
                        <div class="card-icon bg-light text-info rounded">
                            <i class="fas fa-user-tie"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
