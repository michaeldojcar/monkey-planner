<ul class="nav flex-column">
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 mt-3 text-muted">
        <span>Plánovač</span>
        {{--        <a class="d-flex align-items-center text-muted"--}}
        {{--           href="#">--}}
        {{--            <span data-feather="plus-circle"></span>--}}
        {{--        </a>--}}
    </h6>

    <li class="nav-item">
        <a class="nav-link {{ request()->is('user/dash') ? 'active' : '' }}"
           href="{{route('user.dashboard')}}">
            <span data-feather="home"></span>
            Moje nástěnka
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->is('user/groups') ? 'active' : '' }}"
           href="{{route('user.groups.index')}}">
            <span data-feather="users"></span>
            Skupiny
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->is('user/events') ? 'active' : '' }}"
           href="{{route('user.events.index')}}">
            <span data-feather="calendar"></span>
            Události
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->is('user/inventories') ? 'active' : '' }}"
           href="{{route('user.inventories.index')}}">
            <span data-feather="archive"></span>
            Sklady
        </a>
    </li>

    @if(Auth::user()->is_admin)
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Konfigurace</span>
{{--            <a class="d-flex align-items-center text-muted"--}}
{{--               href="#">--}}
{{--                <span data-feather="plus-circle"></span>--}}
{{--            </a>--}}
        </h6>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('organizace-akce/team/*/clenove') ? 'active' : '' }}"
               href="{{route('admin.dashboard')}}">
                <span data-feather="settings"></span>
                Administrace
            </a>
        </li>
    @endif
</ul>

{{--<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">--}}
{{--    <span>Moje přípravné týmy</span>--}}
{{--    <a class="d-flex align-items-center text-muted"--}}
{{--       href="#">--}}
{{--        <span data-feather="plus-circle"></span>--}}
{{--    </a>--}}
{{--</h6>--}}
{{--<ul class="nav flex-column mb-2">--}}

{{--</ul>--}}
