<div class="sidebar sidebar-style-2" data-background-color="dark2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">

            {{-- User Profile --}}
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="../assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
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
                            <li><a href="#profile"><span class="link-collapse">My Profile</span></a></li>
                            <li><a href="#edit"><span class="link-collapse">Edit Profile</span></a></li>
                            <li><a href="#settings"><span class="link-collapse">Settings</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <ul class="nav nav-primary">

                {{-- Hanya tampil jika BUKAN Operator Mesin --}}
                @if(auth()->user()->level !== 'Operator Mesin')
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    {{-- Administrator --}}
                    @if(auth()->user()->level === 'Administrator')
                        <li class="nav-section"><h4 class="text-section">Manajemen Pengguna</h4></li>
                        <li class="nav-item {{ request()->routeIs('users') ? 'active' : '' }}">
                            <a href="{{ route('users') }}"><i class="fas fa-users-cog"></i><p>Data Pengguna</p></a>
                        </li>

                        <li class="nav-section"><h4 class="text-section">Manajemen Mesin</h4></li>
                        <li class="nav-item {{ request()->routeIs('stations.index') ? 'active' : '' }}">
                            <a href="{{ route('stations.index') }}"><i class="fas fa-industry"></i><p>Data Station</p></a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('mesin.index') ? 'active' : '' }}">
                            <a href="{{ route('mesin.index') }}"><i class="fas fa-gears"></i><p>Data Mesin</p></a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('spare_part') ? 'active' : '' }}">
                            <a href="{{ route('spare_part') }}"><i class="fas fa-wrench"></i><p>Data Suku Cadang</p></a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('admin.request-part.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.request-part.index') }}"><i class="fas fa-cube"></i><p>Request Suku Cadang</p></a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('teknisi_mesin.index') ? 'active' : '' }}">
                            <a href="{{ route('teknisi_mesin.index') }}"><i class="fas fa-hard-hat"></i><p>Data Teknisi</p></a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('admin.jadwal.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.jadwal.index') }}"><i class="fas fa-tools"></i><p>Penjadwalan Perbaikan</p></a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('pasca-giling.index') ? 'active' : '' }}">
                            <a href="{{ route('pasca-giling.index') }}"><i class="fas fa-calendar-alt"></i><p>Jadwal Pasca Giling</p></a>
                        </li>
                    @endif

                    {{-- Manajemen Laporan (semua role kecuali operator bisa lihat riwayat) --}}
                    <li class="nav-section"><h4 class="text-section">Manajemen Laporan</h4></li>
                    <li class="nav-item {{ request()->routeIs('admin.riwayat.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.riwayat.index') }}"><i class="fas fa-history"></i><p>Riwayat Perbaikan</p></a>
                    </li>
                @endif

                {{-- Laporan Insidental (bisa diakses SEMUA role) --}}
                @if(in_array(auth()->user()->level, ['Administrator', 'Teknisi', 'Manajer Teknisi', 'Operator Mesin']))
                    <li class="nav-section"><h4 class="text-section">Laporan</h4></li>
                    <li class="nav-item {{ request()->routeIs('laporan-insidental.index') ? 'active' : '' }}">
                        <a href="{{ route('laporan-insidental.index') }}"><i class="fas fa-bug"></i><p>Laporan Insidental</p></a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</div>
