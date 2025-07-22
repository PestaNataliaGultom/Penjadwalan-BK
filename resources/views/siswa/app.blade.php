    <!doctype html> 
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- DataTables CSS (DIPASTIKAN ADA) -->
        <link href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" rel="stylesheet">

        <!-- FullCalendar CSS -->
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/main.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.7/main.min.css" rel="stylesheet" />

        <!-- Custom CSS (tambahkan custom styles) -->
        {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

        <!-- Optional: Add inline styles if needed -->
        <style>
            #calendar {
                background-color: white;
                padding: 20px;
                border-radius: 10px;
                min-height: 500px;
            }
            /* Custom styling */
            body {
                background-color: #f8f9fa;
                font-family: 'Nunito', sans-serif;
                overflow-x: hidden;
            }

            /* Navbar Styling */
            .navbar {
                padding: 0.8rem 1rem;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                z-index: 1030;
                position: sticky;
                background-color: #3490dc;
                top: 0;
                transition: all 0.3s ease;
            }

            .navbar-brand, .nav-link {
                color: white !important;
            }

            .navbar-nav .nav-item .nav-link:hover {
                color: #d1e7ff !important;
            }

            .dropdown-menu {
                background-color: #fff;
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
                border: none;
            }

            .dropdown-item {
                color: #212529;
            }

            .dropdown-item:hover {
                background-color: #e9ecef;
            }

            /* Sidebar Styling */
            #sidebar-wrapper {
                min-height: calc(100vh - 56px);
                width: 250px;
                background: #2c3e50;
                color: #fff;
                transition: all 0.3s;
                position: fixed;
                z-index: 999;
                left: 0;
                box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
            }

            #sidebar-wrapper.collapsed {
                margin-left: -250px;
            }

            .sidebar-heading {
                padding: 1rem 1.5rem;
                font-size: 1.2rem;
                font-weight: bold;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                text-align: center;
            }

            .list-group {
                padding: 0.5rem 0;
            }

            .list-group-item {
                background: transparent;
                color: #ddd;
                border: none;
                padding: 0.75rem 1.5rem;
                transition: all 0.3s;
                display: flex;
                align-items: center;
            }

            .list-group-item i {
                margin-right: 10px;
                width: 20px;
                text-align: center;
            }

            .list-group-item:hover {
                background: rgba(255, 255, 255, 0.1);
                color: #fff;
            }

            .list-group-item.active {
                background-color: #3490dc;
                border-color: #3490dc;
            }

            /* Content area */
            #page-content-wrapper {
                width: 100%;
                padding-left: 250px;
                transition: all 0.3s;
            }

            #page-content-wrapper.expanded {
                padding-left: 0;
            }

            /* For mobile view */
            @media (max-width: 768px) {
                #sidebar-wrapper {
                    margin-left: -250px;
                }
                
                #sidebar-wrapper.active {
                    margin-left: 0;
                }
                
                #page-content-wrapper {
                    padding-left: 0;
                }
                
                #sidebarToggle {
                    display: block;
                }
            }

            /* Page content styling */
            .content-header {
                padding: 1.5rem 0;
                border-bottom: 1px solid #dee2e6;
                margin-bottom: 2rem;
            }

            .content-header h1 {
                margin-bottom: 0;
                font-size: 1.8rem;
                font-weight: 600;
                color: #333;
            }

            /* Dashboard cards */
            .dashboard-card {
                border-radius: 10px;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                transition: transform 0.3s, box-shadow 0.3s;
                margin-bottom: 1.5rem;
                overflow: hidden;
            }

            .dashboard-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            }

            .card-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 60px;
                height: 60px;
                border-radius: 50%;
                margin-bottom: 1rem;
                font-size: 1.5rem;
            }

            /* Toggle button */
            #sidebarToggle {
                background-color: transparent;
                border: none;
                color: white;
                font-size: 1.2rem;
                cursor: pointer;
                padding: 0.25rem 0.75rem;
            }
        </style>
    @stack('styles')
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light shadow-sm">
                <div class="container-fluid">
                    <button class="me-2" id="sidebarToggle">
                        <i class="fas fa-bars text-white"></i>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        SIBEKAL
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto"></ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user me-2"></i> Profile
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="d-flex" id="wrapper">
                <!-- Sidebar -->
                <div id="sidebar-wrapper">
                    <div class="sidebar-heading">MENU</div>
                    <div class="list-group">
                        <a href="{{route('siswa.dashboard')}}" class="list-group-item list-group-item-action {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a href="{{route('siswa.jadwal')}}" class="list-group-item list-group-item-action {{ request()->routeIs('siswa.jadwal') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt"></i> Pengajuan Jadwal
                        </a>
                        {{-- PERBAIKAN DI SINI: Mengubah href="#" menjadi rute yang benar --}}
                        <a href="{{ route('siswa.hasil-konseling') }}" class="list-group-item list-group-item-action {{ request()->routeIs('siswa.hasil-konseling') ? 'active' : '' }}">
                            <i class="fas fa-user-tie"></i> Hasil Konseling
                        </a>
                    </div>
                </div>
                <!-- Page Content -->
                <div id="page-content-wrapper">
                    <main class="py-4">
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
        <!-- PENTING: Urutan Pemuatan JavaScript -->
        <!-- 1. jQuery (Harus dimuat PALING PERTAMA) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <!-- 2. Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- 3. DataTables JS (Membutuhkan jQuery) -->
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

        <!-- 4. SweetAlert2 JS (jika digunakan untuk notifikasi/konfirmasi) -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- 5. Moment.js (Diperlukan untuk formatting tanggal di DataTables siswa) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

        <!-- 6. FullCalendar JS (dan integrasinya, jika bergantung pada Bootstrap/jQuery/Moment.js) -->
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script> 
        <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.7/index.global.min.js"></script> 
        
        {{-- Ini adalah tempat script kustom dari @push('scripts') dari view Anda --}}
        @stack('scripts')
    </body>
    </html>
    