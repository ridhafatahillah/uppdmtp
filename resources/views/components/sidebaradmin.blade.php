<ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav-{{ $id }}" data-bs-toggle="collapse"
            href="#">
            <i class="bi bi-menu-button-wide"></i><span>{{ $nama }}</span><i
                class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav-{{ $id }}" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{ url('admin/kasir/' . $id) }}">
                    <i class="bi bi-grid"></i><span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="admin/rekap/{{ $id }}">
                    <i class="bi bi-file-earmark-text"></i><span>Rekap</span>
                </a>
            </li>
        </ul>
    </li>
</ul>
