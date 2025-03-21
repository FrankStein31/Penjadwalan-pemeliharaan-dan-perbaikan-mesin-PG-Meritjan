<div class="sidebar sidebar-style-2" data-background-color="dark2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('assets/img/profile.jpg') }}" alt="Profile" class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ auth()->user()->nama }}
                            <span class="user-level">{{ auth()->user()->level }}</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="#profile">
                                    <span class="link-collapse">Profil Saya</span>
                                </a>
                            </li>
                            <li>
                                <a href="#edit">
                                    <span class="link-collapse">Edit Profil</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}">
                                    <span class="link-collapse">Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <ul class="nav nav-primary">
                <li class="nav-item {{ request()->routeIs('teknisi.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('teknisi.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                    <h4 class="text-section">Manajemen Mesin</h4>
                </li>
                <li class="nav-item {{ request()->routeIs('teknisi.mesin.index') ? 'active' : '' }}">
                    <a href="{{ route('mesin.index') }}">
                        <i class="fas fa-gears"></i>
                        <p>Data Mesin</p>
                    </a>
                </li>
                {{-- <li class="nav-item {{ request()->routeIs('teknisi.spare_part') ? 'active' : '' }}">
                    <a href="{{ route('teknisi.spare_part') }}">
                        <i class="fas fa-wrench"></i>
                        <p>Data Suku Cadang</p>
                    </a>
                </li> --}}
                {{-- <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                    <h4 class="text-section">Perbaikan dan Pemeliharaan</h4>
                </li> --}}
                <li class="nav-item {{ request()->routeIs('teknisi.jadwal.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.jadwal.indexteknisi') }}">
                        <i class="fas fa-tools"></i>
                        <p>Jadwal Perbaikan</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Laporan Screening</h4>
                </li>

                <li class="nav-item {{ request()->routeIs('screenings.index') ? 'active' : '' }}">
                    <a href="{{ route('screenings.indexteknisi') }}">
                        <i class="fas fa-tasks"></i>
                        <p>Pertanyaan Screening</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                    <h4 class="text-section">Riwayat dan Laporan</h4>
                </li>
                <li class="nav-item {{ request()->routeIs('teknisi.riwayat.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.riwayat.indexteknisi') }}">
                        <i class="fas fa-history"></i>
                        <p>Riwayat Perbaikan</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
