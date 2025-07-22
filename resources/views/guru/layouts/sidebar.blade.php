<div id="sidebar-wrapper">
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>SIBEKAL</h2>
        </div>

        <div class="menu-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
            <a href="{{ route('guru.dashboard') }}" class="menu-link">
                <div class="menu-icon">📊</div>
                <span>Dashboard</span>
            </a>
        </div>

        <div class="menu-item {{ request()->routeIs('guru.jadwal*') ? 'active' : '' }}">
            <a href="{{ route('guru.jadwal') }}" class="menu-link">
                <div class="menu-icon">📅</div>
                <span>Jadwal Konseling</span>
            </a>
        </div>

        <div class="menu-item {{ request()->routeIs('guru.hasil-konseling*') ? 'active' : '' }}">
            <a href="{{ route('guru.hasil-konseling') }}" class="menu-link">
                <div class="menu-icon">📋</div> {{-- Icon diubah menjadi 📋 --}}
                <span>Hasil Konseling</span>
            </a>
        </div>
    </div>
</div>
