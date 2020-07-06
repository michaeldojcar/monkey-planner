<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link {{ request()->is('organizace-akce/team/*/nastenka') ? 'active' : '' }}"
           href="{{route('organize.dashboard',['group_id'=>$group->id])}}">
            <span data-feather="home"></span>
            Moje nástěnka<span class="sr-only">(current)</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('organizace-akce/team/*/program') ? 'active' : '' }}"
           href="{{route('organize.program',['group_id'=>$group->id])}}">
            <span data-feather="file"></span>
            Program
        </a>
    </li>
    {{--<li class="nav-item">--}}
    {{--<a class="nav-link {{ request()->is('organizace-akce/team/*/informace') ? 'active' : '' }}"--}}
    {{--href="{{route('organize.blocks',['group_id'=>$group->id])}}">--}}
    {{--<span data-feather="layers"></span>--}}
    {{--Důležité informace--}}
    {{--</a>--}}
    {{--</li>--}}
    <li class="nav-item">
        <a class="nav-link {{ request()->is('organizace-akce/team/*/ukoly') ? 'active' : '' }}"
           href="{{route('organize.todo',['group_id'=>$group->id])}}">
            <span data-feather="check-square"></span>
            Co je potřeba
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('organizace-akce/team/*/clenove') ? 'active' : '' }}"
           href="{{route('organize.members',['group_id'=>$group->id])}}">
            <span data-feather="users"></span>
            Team
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('organizace-akce/team/*/chat') ? 'active' : '' }}"
           href="https://tabor-dolany.slack.com"
           target="_blank">
            <span data-feather="slack"></span>
            Slack
        </a>
    </li>
    {{--<li class="nav-item">--}}
    {{--<a class="nav-link {{ request()->is('organizace/skupina/*/sklad') ? 'active' : '' }}"--}}
    {{--href="{{route('organize.program',['group_id'=>$group->id])}}">--}}
    {{--<span data-feather="archive"></span>--}}
    {{--Táborový sklad--}}
    {{--</a>--}}
    {{--</li>--}}
    {{--<li class="nav-item">--}}
    {{--<a class="nav-link" href="#">--}}
    {{--<span data-feather="bar-chart-2"></span>--}}
    {{--Statistika--}}
    {{--</a>--}}
    {{--</li>--}}
</ul>

<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
    <span>Moje přípravné týmy</span>
    <a class="d-flex align-items-center text-muted"
       href="#">
        <span data-feather="plus-circle"></span>
    </a>
</h6>
<ul class="nav flex-column mb-2">
    @foreach($group->myGroups() as $subgroup)
        <li class="nav-item {{ request()->is('organizace-akce/podteam/'.$subgroup->id.'/nastenka') ? 'active' : '' }}">
            <a class="nav-link"
               href="{{route('organize.dashboard.subGroup', [$group, $subgroup])}}"
               style="color: purple">
                <span data-feather="users"
                      style="color: purple"></span>
                {{ mb_strtoupper($subgroup->name) }}
            </a>
        </li>
    @endforeach
</ul>

<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
    <span>Další týmy</span>
    <a class="d-flex align-items-center text-muted"
       href="#">
        <span data-feather="plus-circle"></span>
    </a>
</h6>
<ul class="nav flex-column mb-2">
    @foreach($group->otherGroups() as $subgroup)
        <li class="nav-item">
            <a class="nav-link"
               href="{{route('organize.dashboard.subGroup', [$group,$subgroup])}}">
                <span data-feather="users"></span>
                {{ $subgroup->name }}
            </a>
        </li>
    @endforeach
</ul>