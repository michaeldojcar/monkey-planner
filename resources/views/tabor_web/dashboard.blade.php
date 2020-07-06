@extends('tabor_web.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ucfirst($group->mainEvent->name)}} - moje nástěnka</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{route('dashboard')}}"
               class="btn btn-sm btn-outline-secondary">
                Zpět do portálu
            </a>
        </div>
    </div>

    <div class="row d-md-flex">
        <div class="col-sm">
            <p>Ahoj, {{Auth::user()->name_5}}. Vítej ve své vlastní nástěnce na táborovém webu pro vedoucí.
                Na tuto stránku se vždy dostaneš před webovou adresu <a href="http://vedouci.tabordolany.cz">vedouci.tabordolany.cz</a>
            </p>

            <p>Pokud by něco nefungovalo tak jak má, nebo v případě dotazů, napiš na Slack do channelu <b>#technická-podpora</b>
                nebo zavolej na <b>734 791 909</b>.
            </p>

            <div class="row d-none d-md-flex">
                <div class="col-sm-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h1>{{$group->mainEvent->tasks()->count()}}</h1>
                            <h5>{{$lang->sayCount($group->mainEvent->tasks()->count(), 'zapsaná věc','zapsané věci','zapsaných věcí')}}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h1>{{$week_to_event}}</h1>
                            <h5>{{$lang->sayCount($group->mainEvent->tasks()->count(), 'den do tábora','dny do tábora','dní do tábora')}}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h1>{{$group->users()->count()}}</h1>
                            <h5>{{$lang->sayCount($group->users()->count(), 'člověk v týmu', 'lidi v týmu', 'lidí v týmu')}}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            @if($group->mainEvent->notAssignedTasks()->count() > 0)
                                <a href="{{route('organize.todo', $group)}}"
                                   class="btn btn-success float-sm-right mobile-full-width">Napsat se
                                    <br>na něco!</a>

                                <h1 class="{{$group->mainEvent->notAssignedTasks()->count() > 0 ? 'text-danger' : ''}}">{{ $group->mainEvent->notAssignedTasks()->count() }}</h1>
                                <h5>{{$lang->sayCount($group->mainEvent->notAssignedTasks()->count(), 'věc nemá','věci nemají','věcí nemá')}}
                                    garanta</h5>
                            @else
                                <h1>:)</h1>
                                <h5 class="text-success">Všechny úkoly jsou rozebrány.</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(!empty ($group->mainEvent->notice))
            <div class="col-sm">
                <div class="card">
                    <div class="card-header bg-blue text-white font-weight-bold">Důležité informace</div>
                    <div class="card-body">
                        {!! $group->mainEvent->notice !!}
                    </div>

                </div>
            </div>
        @endif
    </div>



    <div class="row margin-bottom">
        <div class="col-md">
            <div class="card">
                <div class="card-header bg-green text-white font-weight-bold"><i class="fa fa-check-square"></i> Moje
                    úkoly
                </div>
                <div class="table-responsive">
                    <table class="table table-striped"
                           style="margin-bottom: 0">
                        <th>Název</th>
                        <th>Má na starost</th>

                        @foreach($my_tasks as $task)
                            <tr>
                                <td><a href="{{route('organize.task',[$group, $task])}}">{{$task->name}}</a>
                                </td>
                                <td>
                                    @include('tabor_web.components.task.garants')
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md">
            <div class="card">
                <div class="card-header bg-green text-white font-weight-bold"><i class="fa fa-check-square"></i> Věci
                </div>
                <div class="table-responsive">
                    <table class="table table-striped"
                           style="margin-bottom: 0">
                        <th>Název</th>
                        <th>Počet</th>
                        <th>Má na starost</th>

                        @foreach($my_items as $task)
                            <tr>
                                <td><a href="{{route('organize.task',[$group, $task])}}">{{$task->name}}</a>
                                </td>
                                <td>{{$task->required_count}}x</td>
                                <td>
                                    @include('tabor_web.components.task.garants')
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md">
            <div class="card">
                <div class="card-header bg-green text-white font-weight-bold"><i class="fa fa-calendar-alt"> </i> Moje
                    hry a program
                </div>
                <div class="table-responsive">
                    <table class="table table-striped"
                           style="margin-bottom: 0">
                        <th>Den tábora</th>
                        <th>Název</th>

                        @foreach($my_events as $event)
                            <tr>
                                <td>{{$event->getDayNumber()}}. DEN</td>
                                <td><a href="{{route('organize.event', [$group, $event])}}">{{$event->name}}</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md">
            <div class="card">
                <div class="card-header bg-green text-white font-weight-bold"><i class="fa fa-user-plus"></i> Moje role
                    v programu
                </div>
                <div class="table-responsive">
                    <table class="table table-striped"
                           style="margin-bottom: 0">
                        <th>Role</th>
                        <th>V rámci programu</th>
                        @foreach($my_roles as $role)
                            <tr>
                                <td>
                                    <a href="{{route('organize.event', [$group, $role->events->where('id','!=',$group->mainEvent->id)->first()])}}">{{$role->name}}</a>
                                </td>
                                <td>
                                    <a style="color: black;"
                                       href="{{route('organize.event',[$group, $role->events->where('id','!=',$group->mainEvent->id)->first()])}}">{{ucfirst($role->events->where('id','!=',$group->mainEvent->id)->first()->name)}}</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')

    @include('tabor_web.tasks.cycleJs')

@endpush