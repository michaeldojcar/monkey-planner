<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link {{ request()->is('organizace-akce/team/*/nastenka') ? 'active' : '' }}"
           href="{{route('user.events.index')}}">
            <span data-feather="home"></span>
            Moje akce
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->is('organizace-akce/team/*/clenove') ? 'active' : '' }}"
           href="{{route('user.groups.index')}}">
            <span data-feather="users"></span>
            Teamy
        </a>
    </li>

    @if(Auth::user()->is_admin)
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Konfigurace</span>
            <a class="d-flex align-items-center text-muted"
               href="#">
                <span data-feather="plus-circle"></span>
            </a>
        </h6>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('organizace-akce/team/*/clenove') ? 'active' : '' }}"
               href="{{route('admin.dashboard')}}">
                <span data-feather="users"></span>
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
