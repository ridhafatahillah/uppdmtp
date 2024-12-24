<aside id="sidebar" class="sidebar">
    @if (auth()->user()->role == 0)
        <ul class="sidebar-nav" id="sidebar-nav">
            <x-nav-link href="/" :active="request()->is('/')">
                <x-slot:icon>bi bi-grid</x-slot:icon>
                Dashboard</x-nav-link>
            <x-nav-link href="rekap" :active="request()->is('rekap')">
                <x-slot:icon>bi bi-file-earmark-text</x-slot:icon>
                Rekap</x-nav-link>
            <span>Pengaturan</span>
            <x-nav-link href="profile" :active="request()->is('profile')">
                <x-slot:icon>bi bi-person</x-slot:icon>
                Akun</x-nav-link>
            <x-nav-link href="logout">
                <x-slot:icon>bi bi-box-arrow-right</x-slot:icon>
                Logout</x-nav-link>
        </ul>
    @else
        @props(['users'])
        <span>Data</span>
        <ul class="sidebar-nav" id="sidebar-nav">
            <x-nav-link href="/admin" :active="request()->is('admin')">
                <x-slot:icon>bi bi-grid</x-slot:icon>
                Dashboard</x-nav-link>
        </ul>
        <span>Master</span>
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                @foreach ($users as $user)
                    <a class="nav-link {{ request()->url() == url('admin/kasir/' . $user->id) || request()->fullUrl() == url('admin/rekap?id=' . $user->id) ? '' : 'collapsed' }}"
                        data-bs-target="#components-nav-{{ $user->id }}" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-menu-button-wide"></i><span>{{ $user->nama }}</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="components-nav-{{ $user->id }}"
                        class="nav-content {{ request()->url() == url('admin/kasir/' . $user->id) || request()->fullUrl() == url('admin/rekap?id=' . $user->id) ? '' : 'collapse' }}"
                        data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ url('admin/kasir/' . $user->id) }}"
                                class="{{ request()->url() == url('admin/kasir/' . $user->id) ? 'active' : '' }}">
                                <i class="bi bi-grid"></i><span>Notes</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/rekap?id=' . $user->id) }}"
                                class="{{ request()->fullUrl() == url('admin/rekap?id=' . $user->id) ? 'active' : '' }}">
                                <i class="bi bi-file-earmark-text"></i><span>Rekap</span>
                            </a>
                        </li>
                    </ul>
                @endforeach
            </li>
        </ul>
        <span>Laporan</span>
        <ul class="sidebar-nav" id="sidebar-nav">
            {{-- buat pengaturan selayaknya admin --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->url() == url('admin/laporan/') || request()->fullUrl() == url('admin/laporan') ? '' : 'collapsed' }}"
                    data-bs-target="#components-nav-laporan" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav-laporan"
                    class="nav-content {{ request()->url() == url('admin/laporan/') || request()->fullUrl() == url('admin/laporan') ? '' : 'collapse' }}"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ url('admin/laporan/') }}"
                            class="{{ request()->url() == url('admin/laporan/') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-text"></i><span>Laporan Harian</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/kasir/') }}"
                            class="{{ request()->url() == url('admin/kasir/') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-text"></i><span>Laporan Bulanan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/rekap?id=') }}"
                            class="{{ request()->fullUrl() == url('admin/rekap?id=') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-text"></i><span>Laporan Tahunan</span>
                        </a>
                    </li>
                </ul>
            </li>
            {{-- <x-nav-link href="{{ url('admin/laporan') }}" :active="request()->is('admin/laporan')">
                <x-slot:icon>bi bi-file-earmark-fill"</x-slot:icon>
                Laporan</x-nav-link> --}}
        </ul>

        <span>Pengaturan</span>
        <ul class="sidebar-nav" id="sidebar-nav">
            {{-- buat pengaturan selayaknya admin --}}
            <x-nav-link href="{{ url('admin/akun') }}" :active="request()->is('admin/akun')">
                <x-slot:icon>bi bi-gear</x-slot:icon>
                Kelola Akun</x-nav-link>
            <x-nav-link href="{{ url('admin/profile') }}" :active="request()->is('admin/profile')">
                <x-slot:icon>bi bi-person</x-slot:icon>
                Profil</x-nav-link>
            <x-nav-link href="{{ url('logout') }}" :active="request()->is('logout')">
                <x-slot:icon>bi bi-box-arrow-right</x-slot:icon>
                Logout</x-nav-link>

        </ul>

    @endif

</aside>
