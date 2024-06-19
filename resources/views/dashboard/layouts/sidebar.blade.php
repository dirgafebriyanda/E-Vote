<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-vote-yea"></i>
        </div>
        <div class="sidebar-brand-text mx-3">simpil</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Menu Utama</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>
    @if (auth()->user()->role == 'Super admin')
        <!-- Nav Item - User -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Daftar Pengguna</span></a>
        </li>
    @endif
    @if (auth()->user()->role == 'Super admin' || auth()->user()->role == 'Admin')
        <!-- Nav Item - Pemilih -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('election.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Daftar Pemilih</span></a>
        </li>

        <!-- Nav Item - Kandidat -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('candidate.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Daftar Kandidat</span></a>
        </li>
    @endif

    <!-- Nav Item - Piliv -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('vote.index', auth()->user()->username) }}">
            <i class="fas fa-fw fa-vote-yea"></i>
            <span>Tentukan Pilihan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
