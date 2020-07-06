<div style="display: inline;">
    @if($event->garants()->count() > 0)
        @foreach($event->garants as $user)
            <span style="color: blue; font-weight: bold; text-transform: uppercase">{{$user->name}}</span>{{ $loop->last ? '' : ', ' }}
        @endforeach
    @else
        <a title="Kliknutím se zapíšete jako garant"
           href="{{route('organize.event.garantAssignUser', [$event, Auth::id()])}}"
           style="text-decoration: none"><span
                    style="color: red; font-weight: bold;">???</span><i
                    class="fas fa-user-edit"></i>
        </a>
    @endif
</div>