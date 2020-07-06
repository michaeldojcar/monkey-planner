{{--User info--}}
@forelse($task->users as $user)
    <span style="color: #0800ff; text-transform: uppercase"
          title="{{$user->getWholeName()}}"><b>{{$user->getNick($main_event)}}</b></span>
    <br>
@empty
    {{-- If user belongs to subgroup, allow assign --}}
    <span style="color: #ff0001; text-transform: uppercase;"><b>???</b></span>
    @if($task->groups->count() > 0 and $task->groups->first()->checkIfAuthBelongsTo())
        <a href="{{route('organize.task.assignMe', $task)}}" style="margin-left: 5px"> - zapsat se :)
            <i class="fas fa-user-edit"></i></a>
    @endif

    {{-- Allow fast assign also, when task is not assigned to any group --}}
    @if($task->groups->count() == 0)
        <a href="{{route('organize.task.assignMe', $task)}}" style="margin-left: 5px"> - zapsat se :)
            <i class="fas fa-user-edit"></i></a>
    @endif
@endforelse
