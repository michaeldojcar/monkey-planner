<a class="navbar-brand"
   href="">
    <img width="30"
         src="{{asset('img/logo_monkey_planner_88px.png')}}"> Monkey planner</a>

<button class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown"
        aria-expanded="false"
        aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse justify-content-between"
     id="navbarNavDropdown">

    <ul class="navbar-nav d-block d-sm-none">

    </ul>

    <ul class="navbar-nav navbar-right invisible d-none d-sm-block"></ul>

    <ul class="navbar-nav">
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

        @auth
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle"
                   href="#"
                   id="navbarDropdownMenuLink"
                   data-toggle="dropdown"
                   aria-haspopup="true"
                   aria-expanded="false">
                    <span data-feather="user"></span>

                    {{Auth::user()->getWholeName()}}
                </a>

                <div class="dropdown-menu"
                     aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item"
                       href="{{route('logout')}}">
                        <i class="fas fa-sign-out-alt"></i>
                        Odhlásit se</a>
                </div>
            </li>
        @endauth
    </ul>
</div>
