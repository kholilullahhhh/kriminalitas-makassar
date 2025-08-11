<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/">Kabupaten Gowa</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/">St</a>
        </div>
        <ul class="sidebar-menu">

            <li class="menu-header">Page Data</li>
            @if(session('role') == 'admin')
            
                <li class="{{ $menu == 'user' ? 'active' : ''}}"><a class="nav-link" href="{{ route('user.index') }}"><i
                            class="fas fa-users"></i><span>Administrasi</span></a></li>
                <li class="{{ $menu == 'uji' ? 'active' : ''}}"><a class="nav-link" href="{{ route('uji.index') }}"><i
                            class="fas fa-print"></i><span>Uji KMeans Method</span></a></li>
                <li class="{{ $menu == 'kriminalitas' ? 'active' : ''}}"><a class="nav-link"
                        href="{{ route('kriminalitas.index') }}"><i class="fas fa-print"></i><span>Data
                            Kriminalitas</span></a></li>
            @endif

            <!-- <li class="{{ $menu == 'warga' ? 'active' : ''}}"><a class="nav-link" href="{{ route('warga.index') }}"><i
                        class="fas fa-print"></i><span>Data Warga</span></a></li> -->
            <li class="{{ $menu == 'kecamatan' ? 'active' : ''}}"><a class="nav-link"
                    href="{{ route('kecamatan.index') }}"><i class="fas fa-print"></i><span>Data Daerah Makassar</span></a>
            </li>
        </ul>
    </aside>
</div>