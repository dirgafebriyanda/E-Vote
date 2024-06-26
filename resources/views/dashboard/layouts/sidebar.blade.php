<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

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
            <span>Dashboard</span>
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
                <span>Users list</span></a>
        </li>
    @endif
    @if (auth()->user()->role == 'Super admin' || auth()->user()->role == 'Admin')
        <!-- Nav Item - Pemilihan -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('election.index') }}">
                <i class="fas fa-fw fa-server"></i>
                <span>Election list</span></a>
        </li>

        <!-- Nav Item - Pemilih -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('voter.index') }}">
                <i class="fas fa-fw fa-id-card"></i>
                <span>Voters list</span></a>
        </li>

        <!-- Nav Item - Kandidat -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('candidate.index') }}">
                <i class="fas fa-fw fa-id-badge"></i>
                <span>Candidates list</span></a>
        </li>
    @endif

    {{-- <!-- Nav Item - Pilih -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('vote.index', auth()->user()->username) }}">
            <i class="fas fa-fw fa-vote-yea"></i>
            <span>Vote</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Votes</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Votes:</h6>
                @foreach ($elections as $item)
                    <a class="collapse-item" href="{{ route('vote2', $item->id) }}">{{ $item->name }}</a>
                @endforeach
            </div>
        </div>
    </li> --}}
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
