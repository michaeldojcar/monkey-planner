<li class="nav-item">
    <a class="nav-link {{ request()->is($active_url) ? 'active' : '' }}"
       href="{{ $href ?? '' }}">
        <span data-feather="{{ $icon ?? 'layers'}}"></span>
        {{ $slot }}
    </a>
</li>