@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content')
<!-- Card Section -->
<div class="row mt-4">
    <!-- Card 1 -->
    <div class="col-md-4 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-header">
                <i class="fas fa-tachometer-alt icon-spacing"></i>
                <h5 class="card-title d-inline">Card 1</h5>
            </div>
            <div class="card-body">
                This is the content for Card 1. You can add more information here.
            </div>
        </div>
    </div>
    <!-- Card 2 -->
    <div class="col-md-4 mb-4">
        <div class="card bg-success text-white">
            <div class="card-header">
                <i class="fas fa-users icon-spacing"></i>
                <h5 class="card-title d-inline">Card 2</h5>
            </div>
            <div class="card-body">
                This is the content for Card 2. You can add more information here.
            </div>
        </div>
    </div>
    <!-- Card 3 -->
    <div class="col-md-4 mb-4">
        <div class="card bg-danger text-white">
            <div class="card-header">
                <i class="fas fa-cogs icon-spacing"></i>
                <h5 class="card-title d-inline">Card 3</h5>
            </div>
            <div class="card-body">
                This is the content for Card 3. You can add more information here.
            </div>
        </div>
    </div>
    <!-- Card 4 -->
    <div class="col-md-4 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-header">
                <i class="fas fa-chart-line icon-spacing"></i>
                <h5 class="card-title d-inline">Card 4</h5>
            </div>
            <div class="card-body">
                This is the content for Card 4. You can add more information here.
            </div>
        </div>
    </div>
    <!-- Card 5 -->
    <div class="col-md-4 mb-4">
        <div class="card bg-info text-white">
            <div class="card-header">
                <i class="fas fa-bell icon-spacing"></i>
                <h5 class="card-title d-inline">Card 5</h5>
            </div>
            <div class="card-body">
                This is the content for Card 5. You can add more information here.
            </div>
        </div>
    </div>
    <!-- Card 6 -->
    <div class="col-md-4 mb-4">
        <div class="card bg-secondary text-white">
            <div class="card-header">
                <i class="fas fa-users-cog icon-spacing"></i>
                <h5 class="card-title d-inline">Card 6</h5>
            </div>
            <div class="card-body">
                This is the content for Card 6. You can add more information here.
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .icon-spacing {
        margin-right: 15px !important;
        /* Pastikan margin diterapkan dengan benar */
    }
</style>
@endsection
