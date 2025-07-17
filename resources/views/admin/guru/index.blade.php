@extends('admin.layouts.app')

@section('title', 'Data Guru')
@section('content')
<div class="container-fluid">
    <div class="content-header">
        <h1>Data Guru </h1>
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
                        <h4 class="card-title">Data List Guru</h4>
                        <a href="{{route('guru.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> Tambah Guru</a>
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
                                    <th>NIP</th>                                
                                    <th>Kapasitas Konseling</th>                                
                                    <th>Alamat</th>
                                    <th>Jabatan</th>
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
                                        <td>{{$user->nip}}</td>
                                        <td>{{$user->capacity}}</td>
                                        <td>{{$user->alamat}}</td>
                                        <td>{{$user->jabatan}}</td>
                                        <td>{{$user->nomor_handphone}}</td>
                                        <td>
                                            <a href="{{route('guru.edit', $user->id)}}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a> | 
                                            <form action="{{ route('guru.destroy', $user->id) }}" method="POST" 
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
