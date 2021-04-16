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
            <a class="nav-link {{ request()->is('inventory/*/dashboard') ? 'active' : '' }}"
               href="{{route('inventory.dashboard', $main_group)}}">
                <span data-feather="home"></span>
                Přehled
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('inventory/*/items*') ? 'active' : '' }}"
               href="{{route('inventory.items.index', $main_group)}}">
                <span data-feather="box"></span>
                Položky
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('inventory/*/item_places*') ? 'active' : '' }}"
               href="{{route('inventory.item_places.index', $main_group)}}">
                <span data-feather="archive"></span>
                Místa
            </a>
        </li>

        @auth
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <span data-feather="user"></span>

                    {{Auth::user()->getWholeName()}}
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{route('logout')}}">
                        <i class="fas fa-sign-out-alt"></i>
                        Odhlásit se</a>
                </div>
            </li>
        @endauth
    </ul>
</div>
