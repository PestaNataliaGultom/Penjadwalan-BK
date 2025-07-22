@extends('siswa.app') {{-- Pastikan ini mengarah ke layout siswa --}}

@section('title', 'Hasil Konseling Saya')

{{-- Tambahkan CSS kustom untuk DataTables di sini (jika diperlukan, sama seperti guru.hasil.blade.php) --}}
@push('styles')
<style>
    /* Memastikan search box menempel ke kanan */
    .dataTables_filter {
        text-align: right !important;
        padding-right: 0 !important;
        margin-right: 0 !important;
    }

    .dataTables_wrapper .row .col-md-6:last-child {
        padding-right: 0 !important;
    }

    .dataTables_filter label input[type="search"] {
        margin-right: 0 !important;
    }
</style>
@endpush

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
                        <th>Tanggal</th>
                        <th>Jenis Masalah</th>
                        <th>Deskripsi Masalah</th>
                        <th>Solusi Masalah</th>
                        <th>Detail</th> {{-- Kolom untuk tombol Lihat Detail --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td> {{-- Format tanggal --}}
                            <td>{{ $item->jenis_masalah }}</td>
                            <td>{{ Str::limit($item->deskripsi_masalah, 50) }}</td> {{-- Batasi teks untuk tampilan tabel --}}
                            <td>{{ Str::limit($item->solusi_masalah, 50) }}</td>
                            <td class="text-center">
                                {{-- Tombol Lihat Detail (menggunakan modal) --}}
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModalSiswa"
                                    data-nama_siswa="{{ $item->nama_siswa }}"
                                    data-nisn="{{ $item->nisn }}"
                                    data-kelas="{{ $item->kelas }}"
                                    data-jurusan="{{ $item->jurusan }}"
                                    data-no_handphone="{{ $item->no_handphone }}"
                                    data-alamat="{{ $item->alamat }}"
                                    data-jadwal="{{ $item->jadwal }}"
                                    data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}"
                                    data-jenis_masalah="{{ $item->jenis_masalah }}"
                                    data-deskripsi_masalah="{{ $item->deskripsi_masalah }}"
                                    data-solusi_masalah="{{ $item->solusi_masalah }}">
                                    <i class="fas fa-eye"></i> Lihat
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada hasil konseling untuk Anda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Detail Hasil Konseling Siswa (ID berbeda dari modal guru) --}}
<div class="modal fade" id="detailModalSiswa" tabindex="-1" aria-labelledby="detailModalSiswaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalSiswaLabel">Detail Hasil Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Siswa</th>
                        <td id="modalSiswaNamaSiswa"></td>
                    </tr>
                    <tr>
                        <th>NISN</th>
                        <td id="modalSiswaNISN"></td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td id="modalSiswaKelas"></td>
                    </tr>
                    <tr>
                        <th>Jurusan</th>
                        <td id="modalSiswaJurusan"></td>
                    </tr>
                    <tr>
                        <th>No HP</th>
                        <td id="modalSiswaNoHP"></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td id="modalSiswaAlamat"></td>
                    </tr>
                    <tr>
                        <th>Jadwal</th>
                        <td id="modalSiswaJadwal"></td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td id="modalSiswaTanggal"></td>
                    </tr>
                    <tr>
                        <th>Jenis Masalah</th>
                        <td id="modalSiswaJenisMasalah"></td>
                    </tr>
                    <tr>
                        <th>Deskripsi Masalah</th>
                        <td id="modalSiswaDeskripsiMasalah"></td>
                    </tr>
                    <tr>
                        <th>Solusi Masalah</th>
                        <td id="modalSiswaSolusiMasalah"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Inisialisasi DataTables untuk tabel siswa
        if ($('#konselingSiswaTable').length) {
            $('#konselingSiswaTable').DataTable({
                "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
                "columns": [
                    { "data": null, "orderable": false, "searchable": false, "className": "text-center",
                      "render": function (data, type, row, meta) {
                          return meta.row + 1;
                      }
                    },
                    { "data": "tanggal",
                      "render": function(data, type, row) {
                          // Format tanggal jika diperlukan (misal: dari YYYY-MM-DD menjadi DD-MM-YYYY)
                          if (type === 'display' || type === 'filter') {
                              // Pastikan moment.js sudah dimuat di layout utama (app.blade.php)
                              return moment(data).format('DD-MM-YYYY');
                          }
                          return data;
                      }
                    },
                    { "data": "jenis_masalah" },
                    { "data": "deskripsi_masalah",
                      "render": function(data, type, row) {
                          // Batasi teks untuk tampilan tabel
                          return data.length > 50 ? data.substr(0, 50) + '...' : data;
                      }
                    },
                    { "data": "solusi_masalah",
                      "render": function(data, type, row) {
                          // Batasi teks untuk tampilan tabel
                          return data.length > 50 ? data.substr(0, 50) + '...' : data;
                      }
                    },
                    { "data": null, "orderable": false, "searchable": false, "className": "text-center",
                      "render": function (data, type, row) {
                          return `
                              <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModalSiswa"
                                  data-nama_siswa="${row.nama_siswa}"
                                  data-nisn="${row.nisn}"
                                  data-kelas="${row.kelas}"
                                  data-jurusan="${row.jurusan}"
                                  data-no_handphone="${row.no_handphone}"
                                  data-alamat="${row.alamat}"
                                  data-jadwal="${row.jadwal}"
                                  data-tanggal="${moment(row.tanggal).format('DD-MM-YYYY')}"
                                  data-jenis_masalah="${row.jenis_masalah}"
                                  data-deskripsi_masalah="${row.deskripsi_masalah}"
                                  data-solusi_masalah="${row.solusi_masalah}">
                                  <i class="fas fa-eye"></i> Lihat
                              </button>
                          `;
                      }
                    }
                ]
            });
        }
        // Logika untuk mengisi modal detail siswa
        var detailModalSiswa = document.getElementById('detailModalSiswa');
        if (detailModalSiswa) {
            detailModalSiswa.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;

                var nama_siswa = button.getAttribute('data-nama_siswa');
                var nisn = button.getAttribute('data-nisn');
                var kelas = button.getAttribute('data-kelas');
                var jurusan = button.getAttribute('data-jurusan');
                var no_handphone = button.getAttribute('data-no_handphone');
                var alamat = button.getAttribute('data-alamat');
                var jadwal = button.getAttribute('data-jadwal');
                var tanggal = button.getAttribute('data-tanggal');
                var jenis_masalah = button.getAttribute('data-jenis_masalah');
                var deskripsi_masalah = button.getAttribute('data-deskripsi_masalah');
                var solusi_masalah = button.getAttribute('data-solusi_masalah');

                document.getElementById('modalSiswaNamaSiswa').textContent = nama_siswa;
                document.getElementById('modalSiswaNISN').textContent = nisn;
                document.getElementById('modalSiswaKelas').textContent = kelas;
                document.getElementById('modalSiswaJurusan').textContent = jurusan;
                document.getElementById('modalSiswaNoHP').textContent = no_handphone;
                document.getElementById('modalSiswaAlamat').textContent = alamat;
                document.getElementById('modalSiswaJadwal').textContent = jadwal;
                document.getElementById('modalSiswaTanggal').textContent = tanggal;
                document.getElementById('modalSiswaJenisMasalah').textContent = jenis_masalah;
                document.getElementById('modalSiswaDeskripsiMasalah').textContent = deskripsi_masalah;
                document.getElementById('modalSiswaSolusiMasalah').textContent = solusi_masalah;
            });
        } else {
            console.error("Elemen modal dengan ID 'detailModalSiswa' tidak ditemukan.");
        }
    });
</script>
@endpush
