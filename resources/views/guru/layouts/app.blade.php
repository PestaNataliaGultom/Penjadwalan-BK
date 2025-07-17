<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
            width: 280px;
            background: #2c3e50;
            color: white;
            padding: 20px 0;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            transition: all 0.3s ease;
            /* z-index: 1020; */
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid #34495e;
            margin-bottom: 20px;
        }

        .sidebar-header h2 {
            font-size: 20px;
            font-weight: 600;
            color: white;
        }

        .menu-item {
            position: relative;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            background: #34495e;
            border-left-color: #4a90e2;
        }

        .menu-item.active {
            background: #4a90e2;
            border-left-color: #fff;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .menu-link:hover {
            color: white;
            text-decoration: none;
        }

        .menu-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .menu-item span {
            font-size: 14px;
            font-weight: 500;
        }

        .navbar {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            /* z-index: 1030; */
            padding-left: 280px;
            transition: all 0.3s ease;
        }

        .navbar #sidebarToggle {
            background-color: #2c3e50;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 15px;
        }

        .navbar #sidebarToggle i {
            color: white;
        }

        #wrapper {
            display: flex;
            width: 100%;
        }

        #page-content-wrapper {
            flex-grow: 1;
            padding-left: 280px;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed {
            margin-left: -280px;
        }

        #page-content-wrapper.expanded {
            padding-left: 0;
        }

        .navbar.sidebar-collapsed-navbar {
            padding-left: 0;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: -280px;
            }

            .sidebar.collapsed {
                margin-left: 0;
            }

            #page-content-wrapper {
                padding-left: 0;
            }

            .navbar {
                padding-left: 0;
            }

            .navbar.sidebar-collapsed-navbar {
                padding-left: 0;
            }

            .sidebar:not(.collapsed) + #page-content-wrapper::before {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                /* z-index: 1010; */
                display: block;
            }
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .stat-icon.blue { background: #4a90e2; }
        .stat-icon.green { background: #27ae60; }
        .stat-icon.orange { background: #f39c12; }
        .stat-icon.teal { background: #1abc9c; }
        .stat-icon.red { background: #fc4545; }
        .stat-icon.primary { background: #0b00a4; }

        .stat-info h3 {
            font-size: 32px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .stat-info p {
            color: #7f8c8d;
            font-size: 14px;
        }

        .content-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            color: #2c3e50;
        }

        .card-body {
            padding: 20px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .main-content {
            padding: 20px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .page-header p {
            color: #7f8c8d;
            font-size: 15px;
        }

        .content-card .table {
            margin-bottom: 0;
        }
        .content-card .table thead th {
            border-bottom: 1px solid #e9ecef;
            padding: 12px 15px;
            font-size: 14px;
            color: #555;
            background-color: #f8f9fa;
        }
        .content-card .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            font-size: 14px;
            color: #666;
        }
    </style>
    @stack('styles')
   
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light shadow-sm">
        <div class="container-fluid">
            <button id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand ms-3" href="{{ url('/') }}">
                SIBEKAL
            </a>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="#">Profile</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="d-flex" id="wrapper">
        @include('guru.layouts.sidebar')
        <div id="page-content-wrapper">
            <main class="py-4">
                <div class="container-fluid">
                    {{-- Tempat konten halaman --}}
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script> 
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.7/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar-wrapper');
            const content = document.getElementById('page-content-wrapper');
            const toggleBtn = document.getElementById('sidebarToggle');
            const navbar = document.querySelector('.navbar');

            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('expanded');
                navbar.classList.toggle('sidebar-collapsed-navbar');
            });

            const responsiveHandler = () => {
                if (window.innerWidth < 768) {
                    sidebar.classList.add('collapsed');
                    content.classList.add('expanded');
                } else {
                    sidebar.classList.remove('collapsed');
                    content.classList.remove('expanded');
                }
            };

            window.addEventListener('resize', responsiveHandler);
            responsiveHandler();
        });
    </script>
    @stack('scripts')
</body>
</html>
