@extends('guru.layouts.app')

@section('title', 'Dashboard Guru BK')

@section('content')        
    <!-- Main Content -->
    <div class="col-md-12">
        <div class="main-content">
            <div class="page-header">
                 <h1>Dashboard {{ Auth::user()->roles->pluck('name')[0] ?? '-' }}</h1>
                <p class="page-subtitle">Ringkasan statistik dan informasi terkini sistem bimbingan konseling</p>
            </div>
            
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon red"><i class="fas fa-bell"></i></div>
                    <div class="stat-info">
                        <h3>{{ Auth::user()->capacity ?? 0 }}</h3>
                        <p>Sisa Kuota Konseling</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon blue">🎓</div>
                    <div class="stat-info">
                        <h3>{{ $totalSiswa }}</h3>
                        <p>Total Siswa</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon orange">📅</div>
                    <div class="stat-info">
                        <h3>{{ $totalKonseling }}</h3>
                        <p>Total Semua Konseling</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon teal">👥</div>
                    <div class="stat-info">
                        <h3>{{ $totalGuruBK }}</h3>
                        <p>Total Guru BK</p>
                    </div>
                </div>
            </div>

            <!-- Content Cards -->
            <div class="grid-2">
                <!-- Konseling Terbaru -->
                <div class="content-card">
                    <div class="card-header">
                        <h3 class="card-title">Konseling Terbaru</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Siswa</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($konselingTerbaru as $konseling)
                                <tr>
                                    <td>{{ $konseling->user->name}}</td>
                                    <td>{{ date('d-m-Y', strtotime($konseling->schedule_date)) }}</td>
                                    <td>{{ $konseling->from_time .' - '. $konseling->to_time }}</td>
                                    <td>
                                       {!! $konseling->status_badge  !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Jadwal Hari Ini -->
                <div class="content-card">
                    <div class="card-header">
                        <h3 class="card-title">Jadwal Hari Ini</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Siswa</th>
                                    {{-- <th>Jenis</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->from_time . '-'. $schedule->to_time }}</td>
                                    <td>{{ $schedule->user?->name }}</td>
                                    {{-- <td>{{ $jadwal['jenis'] }}</td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Kalender FullCalendar -->
                        <div class="mt-4">
                            <h4>Kalender Jadwal Konseling</h4>
                            <div id='calendar'></div>
                        </div>
                        
                        <!-- Content Area for each page -->
                        <div class="mt-4">
                            @yield('content')
                        </div>
                    </div>
                    <div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Buat Jadwal</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="schedule_date">Tanggal Jadwal</label>
                                                <input type="text" class="form-control" placeholder="Tanggal Jadwal" id="schedule_date">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="time_schedule">Jam Jadwal</label>
                                                <input type="time" class="form-control" placeholder="Jam Jadwal" id="time_schedule">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="time_schedule">Guru BK</label>
                                                <select name="guru" id="guru" class="form-control">
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
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (dari CDN) -->
    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script> 
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.7/index.global.min.js"></script>

    <script>

        document.addEventListener('DOMContentLoaded', function() {  
            var calendarEl = document.getElementById('calendar');
            
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                validRange: {
                    start: new Date().toISOString().split('T')[0]
                },
                events: [
                    {
                        title: 'Konseling Siswa A',
                        start: '2025-06-15',
                        extendedProps: {
                            siswa: 'Siswa A',
                            guru: 'Bu Rina',
                            lokasi: 'Ruang BK',
                            deskripsi: 'Masalah motivasi belajar'
                        }
                    },
                    {
                        title: 'Konseling Siswa B',
                        start: '2025-06-18',
                        end: '2025-06-20',
                        extendedProps: {
                            siswa: 'Siswa B',
                            guru: 'Pak Andi',
                            lokasi: 'Ruang BK 2',
                            deskripsi: 'Masalah keluarga'
                        }
                    }
                ],
                 dateClick: function(info) {
                    const clickedDate = new Date(info.dateStr);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    if (clickedDate < today) {
                        alert("Tanggal sudah lewat, tidak bisa memilih.");
                        return;
                    }

                    // Masukkan tanggal ke input form/modal
                    document.getElementById('schedule_date').value = clickedDate.toLocaleDateString('id-ID', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });

                    // Tampilkan modal tambah konseling
                    const modal = new bootstrap.Modal(document.getElementById('eventDetailModal'));
                    modal.show();
                },

                eventClick: function(info) {
                    // Ambil data event
                    const title = info.event.title;
                    const start = info.event.start;
                    const end = info.event.end;
                    const props = info.event.extendedProps;

                    const formatDate = (date) => {
                        return date ? date.toLocaleDateString('id-ID', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        }) : '-';
                    };

                    // Masukkan data ke dalam modal
                    // document.getElementById('modalEventTitle').textContent = title;
                    document.getElementById('schedule_date').value = formatDate(start);
                    // document.getElementById('modalEventEnd').textContent = formatDate(end);

                    // Tampilkan modal
                    const modal = new bootstrap.Modal(document.getElementById('eventDetailModal'));
                    modal.show();
                }
            })
             calendar.render();
        });
        </script>
    @endpush
@endsection
