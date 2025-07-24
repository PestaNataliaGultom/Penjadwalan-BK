@extends('siswa.app') {{-- Pastikan ini mengarah ke layout siswa --}}

@section('title', 'Hasil Konseling Saya')

@section('content')
<div class="container-fluid">
    <div class="content-header">
        <h1 class="mb-4">Hasil Konseling Saya</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Tabel Daftar Hasil Konseling Siswa --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Daftar Hasil Konseling Anda</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-hover" id="konselingSiswaTable"> {{-- Beri ID yang berbeda --}}
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Guru BK</th>
                        <th>Tanggal</th>
                        <th>Durasi</th>
                        <th>Dari Jam</th>
                        <th>Sampe Jam</th>
                        <th>Status</th>
                        <th>Jenis Masalah</th>
                        <th>Deskripsi Masalah</th>
                        <th>Solusi Masalah</th>
                    </tr>
                </thead>
                <tbody>
                     @foreach ($schedules as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->teacher->name}}</td>
                            <td>{{$item->schedule_date}}</td>
                            <td>{{$item->duration}}</td>
                            <td>{{$item->from_time}}</td>
                            <td>{{$item->to_time}}</td>
                            <td>{!! $item->status_badge !!}</td>
                            <td>{{$item->outputSchedule?->category}}</td>
                            <td>{{$item->outputSchedule?->description}}</td>
                            <td>{{$item->outputSchedule?->solution}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#konselingSiswaTable').DataTable();
    });
</script>
@endpush
