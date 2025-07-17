<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan IKM</title>
    <link rel="stylesheet" href="{{ asset('css/laporan.css') }}">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <h2>IKM Dashboard</h2>
            </div>
            <ul>
                <li><a href="/dashboard">Dashboard</a></li>
                <li><a href="#">Data IKM</a></li>
                <li><a href="/dashboard/laporan" class="active">Laporan</a></li>
            </ul>
            <footer>
                <p>Dashboard IKM &copy; 2022 - 2024</p>
                <p>Pemerintah Kota Bandung</p>
            </footer>
        </div>
        
        <!-- Content -->
        <div class="content">
            <header>
                <h1>Laporan Indeks Kepuasan Masyarakat (IKM)</h1>
                <div class="user-info">
                    <span>Kec. Buahbatu</span><br>
                    <span>Access: Specific Area</span>
                </div>
            </header>

            <!-- Main Content -->
            <div class="main-content">
                <h2>Laporan IKM - Oktober 2024</h2>

                <!-- Table Report -->
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kelurahan</th>
                            <th>Jumlah Responden</th>
                            <th>Skor IKM</th>
                            <th>Persentase Kepuasan</th>
                        </tr>
                    </thead>
          
