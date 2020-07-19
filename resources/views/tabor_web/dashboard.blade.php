@extends('tabor_web.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h3>{{ucfirst($main_event->name)}} - nástěnka</h3>

        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{route('user.events.index')}}"
               class="btn btn-sm btn-outline-secondary">
                Zpět do plánovače
            </a>
        </div>
    </div>

    <div class="row d-md-flex">
        <div class="col-sm">
            <p>Ahoj {{Auth::user()->name_5}}. Vítej ve své nástěnce pro přípravu akce {{$main_event->name}}.</p>
        </div>

        @if(!empty ($main_event->notice))
            <div class="col-sm">
                <div class="card">
                    <div class="card-header bg-blue text-white font-weight-bold">Důležité informace</div>
                    <div class="card-body">
                        {!! $main_event->notice !!}
                    </div>

                </div>
            </div>
        @endif
    </div>

    <h4>Moje zodpovědnosti</h4>

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
                                <td><a href="{{route('organize.tasks.edit',[$group, $task])}}">{{$task->name}}</a>
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
                <div class="card-header bg-green text-white font-weight-bold">
                    <i class="fa fa-check-square"></i> Věci, které zajišťuju
                </div>
                <div class="table-responsive">
                    <table class="table table-striped"
                           style="margin-bottom: 0">
                        <th>Název</th>
                        <th>Počet</th>
                        <th>Má na starost</th>

                        @foreach($my_items as $task)
                            <tr>
                                <td><a href="{{route('organize.tasks.edit',[$group, $task])}}">{{$task->name}}</a>
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
                <div class="card-header bg-green text-white font-weight-bold">
                    <i class="fa fa-calendar-alt"> </i> Můj program
                </div>
                <div class="table-responsive">
                    <table class="table table-striped"
                           style="margin-bottom: 0">
                        <th>Den tábora</th>
                        <th>Název</th>

                        @foreach($my_events as $event)
                            <tr>
                                <td>{{$event->getDayNumber()}}. DEN</td>
                                <td>
                                    <a href="{{route('organize.events.show', [$main_event, $event])}}">{{$event->name}}</a>
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
                                    <a href="{{route('organize.events.show', ['event'=>$main_event, $role->events->where('id','!=',$main_event->id)->first()])}}">{{$role->name}}</a>
                                </td>
                                <td>
                                    <a style="color: black;"
                                       href="{{route('organize.events.show',[$main_event, $role->events->where('id','!=',$main_event->id)->first()])}}">{{ucfirst($role->events->where('id','!=',$main_event->id)->first()->name)}}</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <h4>Statistika</h4>

    <div class="row d-md-flex">
        <div class="col-sm-3">
            <div class="card mb-3">
                <div class="card-body">
                    <h1>{{$main_event->tasks()->count()}}</h1>
                    <h5>{{$lang->sayCount($main_event->tasks()->count(), 'zapsaná věc','zapsané věci','zapsaných věcí')}}</h5>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h1>{{$week_to_event}}</h1>
                    <h5>{{$lang->sayCount($main_event->tasks()->count(), 'den do startu','dny do startu','dní do startu')}}</h5>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h1>{{$group->users()->count()}}</h1>
                    <h5>{{$lang->sayCount($group->users()->count(), 'člověk v týmu', 'lidi v týmu', 'lidí v týmu')}}</h5>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    @if($main_event->notAssignedTasks()->count() > 0)
                        <a href="{{route('organize.todo', $group)}}"
                           class="btn btn-success float-sm-right mobile-full-width">Napsat se
                            <br>na něco!</a>

                        <h1 class="{{$main_event->notAssignedTasks()->count() > 0 ? 'text-danger' : ''}}">{{ $main_event->notAssignedTasks()->count() }}</h1>
                        <h5>{{$lang->sayCount($main_event->notAssignedTasks()->count(), 'věc nemá','věci nemají','věcí nemá')}}
                            garanta</h5>
                    @else
                        <h1>:)</h1>
                        <h5 class="text-success">Všechny úkoly jsou rozebrány.</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')

    @include('tabor_web.tasks.cycleJs')

@endpush
