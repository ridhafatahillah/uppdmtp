<li class="nav-item">
    <a class="nav-link {{ $active ? '' : 'collapsed' }}" {{ $attributes }}>
        <i class="{{ $icon }}"></i>
        <span>{{ $slot }}</span>
    </a>
</li>
