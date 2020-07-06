@include('tabor_web.components.task.garant_groups')

@if($task->groups->count())
    /
@endif

@include('tabor_web.components.task.garant_users')