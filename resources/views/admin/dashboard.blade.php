@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('content')
<div class="container-fluid">
    <div class="content-header">
        <h1>Dashboard {{Auth::user()->roles->pluck('name')[0] ?? "-"}}</h1>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card dashboard-card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Siswa</h5>
                            <h2 class="mb-0">{{$totalSiswa}}</h2>
                        </div>
                        <div class="card-icon bg-light text-primary rounded">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Konseling Aktif</h5>
                            <h2 class="mb-0">24</h2>
                        </div>
                        <div class="card-icon bg-light text-success rounded">
                            <i class="fas fa-comments"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Jadwal Hari Ini</h5>
                            <h2 class="mb-0">8</h2>
                        </div>
                        <div class="card-icon bg-light text-warning rounded">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Guru BK</h5>
                            <h2 class="mb-0">{{$totalGuruBK}}</h2>
                        </div>
                        <div class="card-icon bg-light text-info rounded">
                            <i class="fas fa-user-tie"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Content Area for each page -->
    <div class="mt-4">
            <h1>Selamat datang di Dashboard Admin</h1>
    </div>
</div>
@endsection
