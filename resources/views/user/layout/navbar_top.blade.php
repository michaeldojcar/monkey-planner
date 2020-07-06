<a class="navbar-brand"
   href="">
    <img width="20"
         src="{{asset('img/tabor_web/favicon-32x32.png')}}"> Plánovač akcí</a>

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
        <li class="nav-item">
            <a class="nav-link {{ request()->is('planovani/team/*/nastenka') ? 'active' : '' }}"
               href="">
                <span data-feather="home"></span>
                Moje nástěnka
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('organizace-akce/team/*/program') ? 'active' : '' }}"
               href="">
                <span data-feather="file"></span>
                Program tábora
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('planovani/team/*/todo') ? 'active' : '' }}"
               href="">
                <span data-feather="check-square"></span>
                Co je ještě potřeba
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('planovani/team/*/clenove') ? 'active' : '' }}"
               href="">
                <span data-feather="users"></span>
                Team
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link"
               href="https://tabor-dolany.slack.com/">
                <span data-feather="slack"></span>
                Chat
            </a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle"
               href="#"
               id="navbarDropdownMenuLink"
               data-toggle="dropdown"
               aria-haspopup="true"
               aria-expanded="false">
                Nástěnky ostatních PT
            </a>
            <div class="dropdown-menu"
                 aria-labelledby="navbarDropdownMenuLink">

            </div>
        </li>
    </ul>

    <ul class="navbar-nav navbar-right invisible d-none d-sm-block"></ul>

    <ul class="navbar-nav">
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
