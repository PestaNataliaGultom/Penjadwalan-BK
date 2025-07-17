@extends('siswa.app')

@section('title', 'Jadwal Siswa')

@section('content')   
<div class="container-fluid">
   <div class="content-header">
        <h1>Jadwal</h1>
       @if (session('success'))
            <div class="alert alert-success mt-2 alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

       @if (session('error'))
            <div class="alert alert-danger mt-2 alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
      
    </div>
    <div class="col-md-12">
        <div class="main-content">
            <div class="mt-4">
                <h4>Kalender Jadwal Konseling</h4>
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Buat Jadwal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('siswa.jadwalPost')}}" method="POST" id="form-jadwal">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="schedule_date">Tanggal Jadwal</label>
                                <input type="text" name="schedule_date" class="form-control" placeholder="Tanggal Jadwal" id="schedule_date" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="from_time">Durasi</label>
                                <select name="duration" id="duration" class="form-control">
                                    <option value="">Pilih Durasi</option>
                                    @for ($i = 10; $i <= 60; $i += 5) 
                                        {!! "<option value='$i'>$i Menit</option>" !!};
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="time_schedule">Guru BK</label>
                                <select name="guru" id="guru" class="form-control" required>
                                    <option value="">Pilih Guru</option>
                                    @foreach ($guru as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <div class="form-group">
                                <label for="time_schedule">Keterangan</label>
                                <textarea name="ketarangan" class="form-control" id="ketarangan" placeholder="keterangan" rows="6"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
           
        </div>
    </div>
</div>
@include('siswa.detail-jadwal')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var tanggalTerisi = []; // akan diisi dari AJAX

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            validRange: {
                start: new Date().toISOString().split('T')[0]
            },
            events: '{{route("siswa.jadwal.json")}}', // Ambil data dari Laravel

            dateClick: function (info) {
                const clickedDate = info.dateStr;
                const today = new Date().toISOString().split('T')[0];

                // Jika tanggal sudah lewat
                if (clickedDate < today) {
                    alert("Tanggal sudah lewat, tidak bisa memilih.");
                    return;
                }

                // Jika tanggal sudah digunakan (disable klik)
                if (tanggalTerisi.includes(clickedDate)) {
                    alert("Tanggal sudah terisi jadwal, silakan pilih tanggal lain.");
                    return;
                }

                // Masukkan ke form/modal
                document.getElementById('schedule_date').value = new Date(clickedDate).toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                const modal = new bootstrap.Modal(document.getElementById('eventDetailModal'));
                modal.show();
            },

            eventClick: function (info) {
                const start = info.event.start;
                const props = info.event.extendedProps;
               
                $("#t-siswa").text(props.siswa);
                $("#t-guru").text(props.guru);
                $("#t-duration").text(props.duration+' Menit');
                $("#t-deskripsi").text(props.deskripsi);
                $("#t-from-time").text(props.from_time);
                $("#t-to-time").text(props.to_time);
                $("#t-status").html(props.status_badge);
                

                const modal = new bootstrap.Modal(document.getElementById('modal-detail-schedule'));
                modal.show();
            },

            eventDidMount: function(info) {
                // Simpan tanggal-tanggal yang sudah ada jadwal
                const tanggal = info.event.startStr;
                if (!tanggalTerisi.includes(tanggal)) {
                    tanggalTerisi.push(tanggal);
                }
            }
        });

        calendar.render();
    });
</script>
  
@endpush
