<a class="navbar-brand"
   href="{{route('organize.dashboard',$group)}}">
    <img width="20"
         src="{{asset('img/tabor_web/favicon-32x32.png')}}"> {{ucfirst($group->name)}}
    - {{$group->mainEvent->name}}</a>
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
               href="{{route('organize.dashboard',['group_id'=>$group->id])}}">
                <span data-feather="home"></span>
                Moje nástěnka
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('organizace-akce/team/*/program') ? 'active' : '' }}"
               href="{{route('organize.program',['group_id'=>$group->id])}}">
                <span data-feather="file"></span>
                Program tábora
            </a>
        </li>
        {{--        <li class="nav-item">--}}
        {{--            <a class="nav-link {{ request()->is('planovani/team/*/informace') ? 'active' : '' }}"--}}
        {{--               href="{{route('organize.blocks',['group_id'=>$group->id])}}">--}}
        {{--                <span data-feather="layers"></span>--}}
        {{--                Důležité informace--}}
        {{--            </a>--}}
        {{--        </li>--}}
        <li class="nav-item">
            <a class="nav-link {{ request()->is('planovani/team/*/todo') ? 'active' : '' }}"
               href="{{route('organize.todo',['group_id'=>$group->id])}}">
                <span data-feather="check-square"></span>
                Co je ještě potřeba
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('planovani/team/*/clenove') ? 'active' : '' }}"
               href="{{route('organize.members',['group_id'=>$group->id])}}">
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
        @foreach($group->myGroups() as $subgroup)
            <li class="nav-item">
                <a class="nav-link"
                   href="{{route('organize.dashboard.subGroup',[$group, $subgroup])}}">
                    <span data-feather="users"></span>
                    Nástěnka: {{ $subgroup->name }}
                </a>
            </li>
        @endforeach
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
                @foreach($group->otherGroups() as $subgroup)
                    <a class="dropdown-item"
                       href="{{route('organize.dashboard.subGroup',[$group, $subgroup])}}">
                        <span data-feather="users"></span>
                        {{ $subgroup->name }}</a>
                @endforeach
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link"
               href="{{route('logout')}}">
                <i class="fas fa-sign-out-alt"></i>
                Odhlásit se</a>
            </a>
        </li>
    </ul>
</div>