
@extends('layouts.auth.auth')

@section('title', 'Login')

@section('content')

        <div class="w-full max-w-md mx-auto">
          <div class="text-center mb-4">
            <img src="{{ asset('assets/images/logos/logo.png') }}" alt="Logo" width="150">
          </div>
@if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

@endif
<form method="POST" action="{{route('authenticate')}}">
    @csrf
    <h1 class="h3 mb-3 fw-bold text-dark text-center">Login</h1>
    <div class="form-floating">
      <input type="email" class="form-control mb-3" name="email" placeholder="Masukkan Email" required>
      <label for="floatingInput">Email</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control mb-3" name="password" placeholder="Masukkan Password" required>
      <label for="floatingPassword">Password</label>
    </div>

    <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
  </form>
@endsection

