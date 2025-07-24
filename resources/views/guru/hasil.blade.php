@extends('guru.layouts.app')

@section('title', 'Data Hasil Konseling')
@section('content')
<div class="container-fluid">
    <div class="content-header">
        <h1 class="mb-4">Data Hasil Konseling Siswa</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- Tabel Daftar Hasil Konseling --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Daftar Hasil Konseling</h5>
        </div>
        <div class="card-body table-responsive">
            {{-- Tambahkan id untuk DataTables --}}
            <table class="table table-bordered table-striped table-hover" id="konselingTable">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NISN</th>
                        <th>Kelas</th>
                        <th>Tanggal Jadwal</th>
                        <th>Durasi</th>
                        <th>Dari Jam</th>
                        <th>Sampai Jam</th>
                        <th>Status</th>
                        <th>Aksi</th> {{-- Tambahkan kolom Aksi --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->user->name}}</td>
                            <td>{{$item->user->nis}}</td>
                            <td>{{$item->user->kelas}}</td>
                            <td>{{$item->schedule_date}}</td>
                            <td>{{$item->duration}}</td>
                            <td>{{$item->from_time}}</td>
                            <td>{{$item->to_time}}</td>
                            <td>{!! $item->status_badge !!}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm detail" data-schedule="{{ $item->toJson() }}">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Detail Hasil Konseling --}}
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Hasil Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('hasil-konseling.store')}}" method="POST" id="hasilForm">
                @csrf
                <input type="hidden" name="schedule_id" id="scheduleId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama Siswa</th>
                                    <td id="modalNamaSiswa"></td>
                                </tr>
                                <tr>
                                    <th>NISN</th>
                                    <td id="modalNISN"></td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td id="modalTanggal"></td>
                                </tr>
                                <tr>
                                    <th>Durasi</th>
                                    <td id="modalDurasi"></td>
                                </tr>
                                <tr>
                                    <th>Dari Jam</th>
                                    <td id="modalFromTime"></td>
                                </tr>
                                <tr>
                                    <th>Sampai Jam</th>
                                    <td id="modalToTime"></td>
                                </tr>
                                <tr>
                                    <th>Jenis Masalah</th>
                                    <td id="modalJenisMasalah"></td>
                                </tr>
                                <tr>
                                    <th>Deskripsi Masalah</th>
                                    <td id="modalDeskripsiMasalah"></td>
                                </tr>
                                <tr>
                                    <th>Solusi Masalah</th>
                                    <td id="modalSolusiMasalah"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12" id="hasilWrapper">
                            <hr>
                            <h3>Input Hasil Konseling</h3>
                            <div class="form-group">
                                <label>Jenis Masalah</label>
                                <input type="text" class="form-control" name="jenis_masalah" required>
                            </div>
                            <div class="form-group my-2">
                                <label>Deskripsi Masalah</label>
                                <textarea class="form-control" name="deskripsi_masalah" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Solusi Masalah</label>
                                <textarea class="form-control" name="solusi" required></textarea>
                            </div>
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="saveHasilBtn">Simpan Hasil</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#konselingTable').DataTable();
        $('#konselingTable').on('click', '.detail', function() {
            var schedule = $(this).data('schedule');

            $('#scheduleId').val(schedule.id);
            $('#modalNamaSiswa').text(schedule.user.name);
            $('#modalNISN').text(schedule.user.nis);
            $('#modalTanggal').text(schedule.schedule_date);
            $('#modalDurasi').text(schedule.duration);
            $('#modalFromTime').text(schedule.from_time);
            $('#modalToTime').text(schedule.to_time);
          

            if(schedule.output_schedule){
                $('#modalJenisMasalah').text(schedule.output_schedule.category);
                $('#modalDeskripsiMasalah').text(schedule.output_schedule.description);
                $('#modalSolusiMasalah').text(schedule.output_schedule.solution);
                $('#hasilWrapper').hide();
                $('#saveHasilBtn').hide();
                // $("#hasilForm").hide();
            }else{
                $('#hasilWrapper').show();
                $('#saveHasilBtn').show();
                // $('#hasilForm').show();
            }
            $('#detailModal').modal('show');
        });
    });
</script>
@endpush
