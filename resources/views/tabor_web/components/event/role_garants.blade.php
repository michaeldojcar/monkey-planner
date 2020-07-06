<div style="display: inline">
    @foreach($task->users as $user)
        <a title="Odebrat uživatele z role {{$task->name}}." style="color: black"
           href="{{route('organize.event.roleUnassignUser', [$task, $user->id])}}">
            <span style="color: blue; font-weight: bold; text-transform: uppercase">{{$user->name}}</span>{{ $loop->last ? '' : ', ' }}{{ $task->getUnassignedUserPlacesCount() > 0 ? ', ' : '' }}
        </a>
    @endforeach

    @if($task->getUnassignedUserPlacesCount() > 0)
        @if(! $task->isAuthAssigned())
            <a title="Kliknutím se zapsat." style="color: black"
               href="{{route('organize.event.roleAssignUser', [$task, Auth::id()])}}">
                <b>{{$task->getUnassignedUserPlacesCount()}}x </b>
                <span style="font-weight: bold; color: red">???</span>
            </a>
        @else
            <b>{{$task->getUnassignedUserPlacesCount()}}x </b>
            <span style="font-weight: bold; color: red">???</span>
        @endif
    @endif
</div>