@if($event->getAuthUserParticipationStatus() == 4)
    <a class="btn btn-outline-primary"
       href="#" title="Jste pořadatelem této události.">
        <i class="fas fa-crown"></i>
    </a>
@else
    <div class="btn-group" role="group" aria-label="Basic example">
        <a class="btn {{ $event->getAuthUserParticipationStatus() == 1 ? 'btn-success' : 'btn-outline-secondary' }}"
           href="{{route('event.participate',['event_id'=>$event->id, 'status'=>1])}} ">
            <i class="fas fa-check"></i>
        </a>
        <a class="btn {{ $event->getAuthUserParticipationStatus() == 2 ? 'btn-warning' : 'btn-outline-secondary' }}"
           href="{{route('event.participate',['event_id'=>$event->id, 'status'=>2])}} ">
            <i class="fas fa-question"></i>
        </a>
        <a class="btn {{ $event->getAuthUserParticipationStatus() == 3 ? 'btn-danger' : 'btn-outline-secondary' }}"
           href="{{route('event.participate',['event_id'=>$event->id, 'status'=>3])}} ">
            <i class="fas fa-times"></i>
        </a>
    </div>
@endif