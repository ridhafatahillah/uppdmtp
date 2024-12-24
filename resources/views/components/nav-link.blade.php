@props(['active' => false, 'icon' => ''])

@php
    $classes = $active ? 'nav-link' : 'nav-link collapsed';
@endphp

<li class="nav-item">
    <a class="{{ $classes }}" {{ $attributes }}>
        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif
        <span>{{ $slot }}</span>
    </a>
</li>
