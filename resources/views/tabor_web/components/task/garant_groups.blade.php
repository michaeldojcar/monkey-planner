@if($task->groups->count() > 0)
    @if($task->groups->first()->id == $group->id)
        <i><b>všichni</b></i>
    @elseif($task->groups->count() == 1)
        @component('tabor_web.components.user_picker.generic_group', ['group' => $task->groups[0]])@endcomponent
    @elseif($task->groups->count() == 2)
        @component('tabor_web.components.user_picker.generic_group', ['group' => $task->groups[0]])@endcomponent + @component('tabor_web.components.user_picker.generic_group', ['group' => $task->groups[1]])@endcomponent
    @elseif($task->groups->count() == 3)
        @component('tabor_web.components.user_picker.generic_group_short', ['group' => $task->groups[0]])@endcomponent + @component('tabor_web.components.user_picker.generic_group_short', ['group' => $task->groups[2]])@endcomponent + @component('tabor_web.components.user_picker.generic_group_short', ['group' => $task->groups[2]])@endcomponent
    @endif
@endif