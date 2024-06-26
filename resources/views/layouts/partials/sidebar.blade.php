<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="{{ route('home') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                @can('admin')
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Data Users
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('super-editor') }}">Super Editor</a>
                        <a class="nav-link" href="{{ route('editor') }}">Editor</a>
                        <a class="nav-link" href="{{ route('wartawan') }}">Wartawan</a>
                    </nav>
                </div>
                @endcan

                @if (auth()->user()->role != 'admin')
                <a class="nav-link" href="{{ route('berita') }}">
                    <div class="sb-nav-link-icon"><i class="far fa-file-alt"></i></div>
                    News List
                </a>
                <a class="nav-link" href="{{ route('berita.create') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                    Add News
                </a>
                @endif
                <a class="nav-link" href="{{ route('profile.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-edit"></i></div>
                    Edit Profile
                </a>
                <a class="nav-link" href="{{ route('profile.password') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-unlock-alt"></i></div>
                    Change Password
                </a>

                <hr>

                <a class="nav-link btn-logout" href="#">
                    <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ auth()->user()->role }}
        </div>
    </nav>
</div>