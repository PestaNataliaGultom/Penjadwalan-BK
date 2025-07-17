@extends('layouts.admin.master')

@section('title', 'Tambah Siswa')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Tambah Data Siswa</h5>
            </div>
            <div class="card-body">
                <form action="/siswa" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="text" 
                               class="form-control @error('nisn') is-invalid @enderror" 
                               id="nisn" 
                               name="nisn" 
                               value="{{ old('nisn') }}" 
                               placeholder="Masukkan NISN siswa"
                               required>
                        @error('nisn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" 
                               class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" 
                               name="nama" 
                               value="{{ old('nama') }}" 
                               placeholder="Masukkan nama lengkap siswa"
                               required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kelas" class="form-label">Kelas</label>
                                <select class="form-select @error('kelas') is-invalid @enderror" 
                                        id="kelas" 
                                        name="kelas" 
                                        required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>X</option>
                                    <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>XI</option>
                                    <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>XII</option>
                                </select>
                                @error('kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jurusan" class="form-label">Jurusan</label>
                                <select class="form-select @error('jurusan') is-invalid @enderror" 
                                        id="jurusan" 
                                        name="jurusan" 
                                        required>
                                    <option value="">Pilih Jurusan</option>
                                    <option value="Perbankan" {{ old('jurusan') == 'Perbangkan' ? 'selected' : '' }}>Perbankan</option>
                                    <option value="TKJ" {{ old('jurusan') == 'TKJ' ? 'selected' : '' }}>Teknik Komputer dan Jaringan</option>
                                </select>
                                @error('jurusan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" 
                                  class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat"
                                  rows="3" 
                                  placeholder="Masukkan alamat lengkap siswa"
                                  required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="contoh@email.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telepon" class="form-label">No. Telepon</label>
                                <input type="tel" 
                                       class="form-control @error('telepon') is-invalid @enderror" 
                                       id="telepon" 
                                       name="telepon" 
                                       value="{{ old('telepon') }}" 
                                       placeholder="08xxxxxxxxxx"
                                       required>
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/siswa" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection