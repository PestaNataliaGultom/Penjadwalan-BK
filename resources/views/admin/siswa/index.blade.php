@extends('admin.layouts.app')

@section('title', 'Data Siswa')
@section('content')
<div class="container-fluid">
    <div class="content-header">
        <h1>Data Siswa </h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
              @if (session('error'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Data List Siswa</h4>
                        <a href="{{route('siswa.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> Tambah Siswa</a>
                    </div>
                </div>
                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table class="table table-striped" id="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>NIS</th>
                                    <th>Kelas</th>
                                    <th>Jurusan</th>
                                    <th>Alamat</th>
                                    <th>Nomor Handphone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->nis}}</td>
                                        <td>{{$user->kelas}}</td>
                                        <td>{{$user->jurusan}}</td>
                                        <td>{{$user->alamat}}</td>
                                        <td>{{$user->nomor_handphone}}</td>
                                        <td>
                                            <a href="{{route('siswa.edit', $user->id)}}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a> | 
                                            <form action="{{ route('siswa.destroy', $user->id) }}" method="POST" 
                                                class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
