@extends('tabor_web.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Co je potřeba?</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a class="btn btn-primary mr-2"
               href="{{route('organize.tasks', $group)}}">Všechny úkoly</a>
        </div>
    </div>

    {{--Progress bar--}}
    <div class="progress"
         style="height:20px; margin-bottom: 20px">
        <div class="progress-bar progress-bar-striped bg-primary"
             role="progressbar"
             style="width: 0%"
             id="percentAssigned"><span id="percentAssignedLabel"
                                        class="font-weight-bolder"></span>
        </div>
    </div>

    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">Chybějící garant
                    <span class="badge badge-secondary">{{ $events_without_garant->count() }}</span></div>
                <div class="card-body">
                    Tyto části programu nemají svého garanta. Protože loni jsme chtěli, aby každou hru hlídal na táboře
                    programák, je potřeba, aby se na ni někdo jako garant dopsal.

                    <hr>

                    @forelse($events_without_garant as $event)
                        {{$event->getTypeEmoji()}}
                        <a href="{{route('organize.event', [$group,$event])}}">{{$event->name}}</a>{{$loop->last ? '' : ','}}
                        <br>
                    @empty
                        <span class="text-success">Hurá. Všech {{$group->mainEvent->events()->count()}} her má svého garanta. :)</span>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-sm">
            <div class="card">
                <div class="card-header">Neobsazené role
                    <span class="badge badge-secondary">{{ $events_with_missing_roles->count() }}</span></div>
                <div class="card-body">
                    Při zapisování se do rolí mrkněte, jestli náhodou v dané hře nemáte jinou roli nebo nehrajete s
                    vlastní skupinkou.

                    <hr>

                    @forelse($events_with_missing_roles as $event)
                        {{$event->getTypeEmoji()}}
                        <a href="{{route('organize.event', [$group,$event])}}">{{ $event->name }}</a>{{$loop->last ? '' : ','}}
                        <br>
                    @empty
                        <span class="text-success">Všechny role ve hrách jsou obsazeny.</span>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-sm">
            <div class="card">
                <div class="card-header">Chybějící popis
                    <span class="badge badge-secondary">{{ $incomplete_events->count() }}</span></div>
                <div class="card-body">
                    <p>Pokud hra/program nemá vyplněnou některou část popisku, zobrazí se tady. Stačí do hry vyplnit
                        zbývající
                        informace.</p>
                    <hr>

                    @forelse($incomplete_events as $event)
                        {{$event->getTypeEmoji()}}
                        <a href="{{route('organize.event', [$group,$event])}}">{{$event->name}}</a>{{$loop->last ? '' : ','}}
                        <br>
                    @empty
                        <span class="text-success">Všechny bloky programu jsou popsané.</span>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-sm">
            <div class="card">
                <div class="card-header">Úkoly k zapsání
                    <span class="badge badge-secondary">{{ $tasks_without_user->count() }}</span></div>
                <div class="card-body">
                    <p>Na tyto úkoly není nikdo zapsaný.</p>
                    <hr>

                    @forelse($tasks_without_user as $task)
                        <div style="margin-bottom: 5px">
                            <a href="{{route('organize.task', [$group,$task])}}">{{ucfirst($task->name)}}</a>
                        </div>
                    @empty
                        <span class="text-success">Všechny úkoly jsou vyřešené.</span>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-sm">
            <div class="card">
                <div class="card-header">Rekvizity k zapsání
                    <span class="badge badge-secondary">{{ $items_without_user->count() }}</span></div>
                <div class="card-body">
                    <p>K těmto věcem a rekvizitám není nikdo zapsaný.</p>
                    <hr>

                    @forelse($items_without_user as $task)
                        <div style="margin-bottom: 5px">
                            <a href="{{route('organize.task', [$group,$task])}}">{{ucfirst($task->name)}}</a>
                        </div>
                    @empty
                        <span class="text-success">Všechny věci jsou zapsané.</span>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    @include('tabor_web.tasks.cycleJs')

    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs4/dt-1.10.18/fh-3.1.4/r-2.2.2/datatables.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#data-table").DataTable();
        });

        $("#data-table").DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Czech.json'
            }
        });
    </script>

    <script>
        function updateProgressBar(assigned) {
            $('#percentAssigned').width(assigned + '%');
            $('#percentAssignedLabel').text(assigned + ' % úkolů je zapsaných');
        }

        updateProgressBar({{$percent_assigned}});
    </script>
@endpush