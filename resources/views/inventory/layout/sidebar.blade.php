<ul class="nav flex-column">

    @component('layouts.menu-item')
        Návrat do plánovače
        @slot('href', route('user.inventories.index'))
        @slot('active_url', 'user')
        @slot('icon', 'corner-up-left')
    @endcomponent

    @php
        use App\Group;

        $id = Request::route('group_id');
        $main_group = Group::findOrFail($id);
    @endphp

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 mt-3 text-muted">
        <span>{{$main_group->name}} - inventář</span>
        {{--        <a class="d-flex align-items-center text-muted"--}}
        {{--           href="#">--}}
        {{--            <span data-feather="plus-circle"></span>--}}
        {{--        </a>--}}
    </h6>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('inventory/*/dashboard') ? 'active' : '' }}"
               href="{{route('inventory.dashboard', $main_group)}}">
                <span data-feather="home"></span>
                Přehled
            </a>
        </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->is('inventory/*/items') ? 'active' : '' }}"
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

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 mt-3 text-muted">
        <span>Kategorie</span>
        {{--        <a class="d-flex align-items-center text-muted"--}}
        {{--           href="#">--}}
        {{--            <span data-feather="plus-circle"></span>--}}
        {{--        </a>--}}
    </h6>

{{--        @foreach($main_place->item_places as $main_subplace)--}}
{{--    <li class="nav-item">--}}
{{--        <a class="nav-link {{ request()->is('user/events') ? 'active' : '' }}"--}}
{{--           href="{{route('user.events.index')}}">--}}
{{--            <span data-feather="codesandbox"></span>--}}
{{--            Kategorie--}}
{{--        </a>--}}
{{--    </li>--}}
{{--        @endforeach--}}
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
