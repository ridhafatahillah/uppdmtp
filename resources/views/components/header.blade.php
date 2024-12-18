@php

    $tanggal = getIndonesianMonth(date('n')) . ' ' . date('d ');
@endphp

<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="/" class="logo d-flex justify-content-center">
            @mobile
                <img src="{{ asset('img/logohp.png') }}" alt="Logo HP" />
            @else
                <img src="{{ asset('img/logo.png') }}" alt="Logo Laptop" style="scale: 100%" />
            @endmobile
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item d-flex pe-3 mt-2">
                {{-- <h6 class="align-items-center fw-bold d-none d-md-table-cell" onclick='copyToClipboard(this)'
                    id="tanggal" value="{{ $tanggal }}">
                    {{ $tanggal }} </h6>
                <h6 class="mx-2 fw d-none d-md-table-cell">I</h6>
                <h6 id="clock" class="fw-bold"> {{ date('H:i') }}</h6> --}}
                <h6>{{ Auth::user()->nama_kasir }}</h6>
            </li>
        </ul>
    </nav>
</header>
