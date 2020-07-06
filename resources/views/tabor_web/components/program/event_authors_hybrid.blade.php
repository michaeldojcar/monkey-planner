<div style="display: inline;">

</div>

{{-- Assigned group --}}
@if($event->groups()->count() > 0)
    @foreach($event->groups as $group)
        <span style="color: #9300b0; font-weight: bold; text-transform: uppercase">{{$group->name}}</span>{{ $loop->last ? '' : ', ' }}
    @endforeach
@endif

{{-- Slash --}}
@if($event->groups()->count() > 0 and $event->users()->count() > 0)
    /
@endif


@if($event->authors()->count() > 0)
    @foreach($event->authors as $user)
        <span style="color: blue; font-weight: bold; text-transform: uppercase">{{$user->getNick($event)}}</span>{{ $loop->last ? '' : ', ' }}
    @endforeach
@endif

{{ $event->authors()->count() > 0 && $event->garants()->count() ? ',' : '' }}


@if($event->garants()->count() > 0)
    Garant:
    @foreach($event->garants as $user)
        <span style="color: blue; font-weight: bold; text-transform: uppercase">{{$user->getNick($event)}}</span>{{ $loop->last ? '' : ', ' }}
    @endforeach
@endif

@if($event->groups()->count() == 0 and $event->users()->count() == 0)
    {{-- No group nor user, can assign from ??? --}}
    <a title="Kliknutím se zapíšete jako author"
       href="{{route('organize.event.authorAssignUser', [$event, Auth::id()])}}">
        <span style="color: red; font-weight: bold">???</span>
    </a>
@endif