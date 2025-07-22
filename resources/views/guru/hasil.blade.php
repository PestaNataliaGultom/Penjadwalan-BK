@extends('guru.layouts.app')

@section('title', 'Input Hasil Konseling')

{{-- Tambahkan CSS kustom untuk DataTables di sini --}}
@push('styles')
<style>
    /* Memastikan search box menempel ke kanan */
    .dataTables_filter {
        text-align: right !important; /* Memastikan teks dan input rata kanan */
        padding-right: 0 !important;  /* Menghilangkan padding kanan */
        margin-right: 0 !important;   /* Menghilangkan margin kanan */
    }

    /* Juga pastikan kolom Bootstrap yang membungkusnya tidak memiliki padding kanan */
    .dataTables_wrapper .row .col-md-6:last-child {
        padding-right: 0 !important;
    }

    /* Jika masih ada sedikit ruang, mungkin input field itu sendiri memiliki margin */
    .dataTables_filter label input[type="search"] {
        margin-right: 0 !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="content-header">
        <h1 class="mb-4">Input Hasil Konseling Siswa</h1>
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

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Form Input Hasil Konseling</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('hasil-konseling.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_siswa">Nama Siswa</label>
                        <input type="text" name="nama_siswa" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nisn">NISN</label>
                        <input type="text" name="nisn" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kelas">Kelas</label>
                        <input type="text" name="kelas" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jurusan">Jurusan</label>
                        <input type="text" name="jurusan" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="no_handphone">No HP</label>
                        <input type="text" name="no_handphone" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jadwal">Jadwal</label>
                        <input type="text" name="jadwal" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal">Tanggal Konseling</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jenis_masalah">Jenis Masalah</label>
                        <select name="jenis_masalah" class="form-control" required>
                            <option value="" disabled selected>Pilih Jenis Masalah</option>
                            <option value="Masalah Pribadi">Masalah Pribadi</option>
                            <option value="Masalah Keluarga">Masalah Keluarga</option>
                            <option value="Masalah Sosial">Masalah Sosial</option>
                            <option value="Masalah Akademik">Masalah Akademik</option>
                            <option value="Masalah Disiplin">Masalah Disiplin</option>
                            <option value="Bolos Sekolah">Bolos Sekolah</option>
                            <option value="Pelanggaran Tata Tertib">Pelanggaran Tata Tertib</option>
                            <option value="Masalah Percintaan">Masalah Percintaan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="deskripsi_masalah">Deskripsi Masalah</label>
                        <textarea name="deskripsi_masalah" rows="3" class="form-control" required></textarea>
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="solusi_masalah">Solusi Masalah</label>
                        <textarea name="solusi_masalah" rows="3" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('guru.hasil-konseling') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>

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
                        <th>Aksi</th> {{-- Tambahkan kolom Aksi --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_siswa }}</td>
                            <td>{{ $item->nisn }}</td>
                            <td>{{ $item->kelas }}</td>
                            <td class="text-center">
                                {{-- Tombol Lihat Detail (menggunakan modal) --}}
                                <button type="button" class="btn btn-info btn-sm me-1" data-bs-toggle="modal" data-bs-target="#detailModal"
                                    data-nama_siswa="{{ $item->nama_siswa }}"
                                    data-nisn="{{ $item->nisn }}"
                                    data-kelas="{{ $item->kelas }}"
                                    data-jurusan="{{ $item->jurusan }}"
                                    data-no_handphone="{{ $item->no_handphone }}"
                                    data-alamat="{{ $item->alamat }}"
                                    data-jadwal="{{ $item->jadwal }}"
                                    data-tanggal="{{ $item->tanggal }}"
                                    data-jenis_masalah="{{ $item->jenis_masalah }}"
                                    data-deskripsi_masalah="{{ $item->deskripsi_masalah }}"
                                    data-solusi_masalah="{{ $item->solusi_masalah }}">
                                    <i class="fas fa-eye"></i> Lihat
                                </button>
                                {{-- Tombol Edit --}}
                                <a href="{{ route('guru.hasil-konseling.edit', $item->id) }}" class="btn btn-success btn-sm me-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                {{-- Tombol Delete (menggunakan form untuk POST request) --}}
                                <form action="{{ route('guru.hasil-konseling.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Detail Hasil Konseling --}}
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Hasil Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                        <th>Kelas</th>
                        <td id="modalKelas"></td>
                    </tr>
                    <tr>
                        <th>Jurusan</th>
                        <td id="modalJurusan"></td>
                    </tr>
                    <tr>
                        <th>No HP</th>
                        <td id="modalNoHP"></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td id="modalAlamat"></td>
                    </tr>
                    <tr>
                        <th>Jadwal</th>
                        <td id="modalJadwal"></td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td id="modalTanggal"></td>
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
        // Inisialisasi DataTables
        // Memastikan elemen #konselingTable ada sebelum menginisialisasi DataTables
        if ($('#konselingTable').length) {
            $('#konselingTable').DataTable({
            $('#konselingTable').DataTable({
            "autoWidth": false,
            "ordering": true,
            "paging": true,
            "info": true,
            "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip' 
            });
        }

        // Logika untuk mengisi modal detail
        var detailModal = document.getElementById('detailModal');
        // Pastikan elemen modal ditemukan sebelum menambahkan event listener
        if (detailModal) {
            detailModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; // Button that triggered the modal

                // Extract info from data-bs-* attributes
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

                // Update the modal's content.
                document.getElementById('modalNamaSiswa').textContent = nama_siswa;
                document.getElementById('modalNISN').textContent = nisn;
                document.getElementById('modalKelas').textContent = kelas;
                document.getElementById('modalJurusan').textContent = jurusan;
                document.getElementById('modalNoHP').textContent = no_handphone;
                document.getElementById('modalAlamat').textContent = alamat;
                document.getElementById('modalJadwal').textContent = jadwal;
                document.getElementById('modalTanggal').textContent = tanggal;
                document.getElementById('modalJenisMasalah').textContent = jenis_masalah;
                document.getElementById('modalDeskripsiMasalah').textContent = deskripsi_masalah;
                document.getElementById('modalSolusiMasalah').textContent = solusi_masalah;
            });
        } else {
            console.error("Elemen modal dengan ID 'detailModal' tidak ditemukan.");
        }


        // Konfirmasi Hapus
        $('.delete-form').on('submit', function(e) {
            e.preventDefault(); // Mencegah submit form default
            var form = this;
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan bisa mengembalikan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Jika dikonfirmasi, submit form
                }
            });
        });
    });
</script>
@endpush
