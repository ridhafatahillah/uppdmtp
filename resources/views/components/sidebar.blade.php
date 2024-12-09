<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <x-nav-link href="/" :active="request()->is('/')">
            <x-slot:icon>bi bi-grid</x-slot:icon>
            Dashboard</x-nav-link>
        <x-nav-link href="rekap" :active="request()->is('rekap')">
            <x-slot:icon>bi bi-file-earmark-text</x-slot:icon>
            Rekap</x-nav-link>
        <x-nav-link href="logout" :active="request()->is('tambah')">
            <x-slot:icon>bi bi-box-arrow-right</x-slot:icon>
            Logout</x-nav-link>

    </ul>
</aside>
