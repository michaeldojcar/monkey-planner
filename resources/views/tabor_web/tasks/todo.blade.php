@extends('tabor_web.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Co je potřeba?</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a class="btn btn-primary mr-2"
               href="{{route('organize.tasks.index', $group)}}">Všechny úkoly</a>
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
                    @if($events_without_garant->count())
                        <div class="alert alert-warning">Části programu s chybějícím garantem.</div>
                    @endif

                    @forelse($events_without_garant as $event)
                        {{$event->getTypeEmoji()}}
                        <a href="{{route('organize.events.show', [$group,$event])}}">{{$event->name}}</a>{{$loop->last ? '' : ','}}
                        <br>
                    @empty
                        <div class="alert alert-success">Hurá. Všechny části programu mají svého garanta.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-sm">
            <div class="card">
                <div class="card-header">Neobsazené role
                    <span class="badge badge-secondary">{{ $events_with_missing_roles->count() }}</span></div>
                <div class="card-body">
                    @if($events_with_missing_roles->count())
                        <div class="alert alert-warning">Neobsazené role v programu, které je potřeba obsadit.</div>
                    @endif

                    @forelse($events_with_missing_roles as $event)
                        {{$event->getTypeEmoji()}}
                        <a href="{{route('organize.events.show', [$group,$event])}}">{{ $event->name }}</a>{{$loop->last ? '' : ','}}
                        <br>
                    @empty
                        <div class="alert alert-success">Všechny role v programu jsou obsazeny.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-sm">
            <div class="card">
                <div class="card-header">Chybějící popis
                    <span class="badge badge-secondary">{{ $incomplete_events->count() }}</span></div>
                <div class="card-body">
                    @if($incomplete_events->count())
                        <div class="alert alert-warning">Části programu s prázdnými popisky.</div>
                    @endif

                    @forelse($incomplete_events as $event)
                        {{$event->getTypeEmoji()}}
                        <a href="{{route('organize.events.show', [$group,$event])}}">{{$event->name}}</a>{{$loop->last ? '' : ','}}
                        <br>
                    @empty
                        <div class="alert alert-success">Všechny bloky programu jsou popsané.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-sm">
            <div class="card">
                <div class="card-header">Úkoly k zapsání
                    <span class="badge badge-secondary">{{ $tasks_without_user->count() }}</span></div>
                <div class="card-body">
                    @if($tasks_without_user->count())
                        <div class="alert alert-warning">Na tyto úkoly není nikdo zapsaný.</div>
                    @endif

                    @forelse($tasks_without_user as $task)
                        <div style="margin-bottom: 5px">
                            <a href="{{route('organize.tasks.show', [$group,$task])}}">{{ucfirst($task->name)}}</a>
                        </div>
                    @empty
                        <div class="alert alert-success">Všechny úkoly jsou vyřešené.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-sm">
            <div class="card">
                <div class="card-header">Zajištění materiálu
                    <span class="badge badge-secondary">{{ $items_without_user->count() }}</span></div>
                <div class="card-body">
                    @if($items_without_user->count())
                        <div class="alert alert-warning">K těmto věcem a rekvizitám není nikdo zapsaný.</div>
                    @endif

                    @forelse($items_without_user as $task)
                        <div style="margin-bottom: 5px">
                            <a href="{{route('organize.tasks.show', [$group,$task])}}">{{ucfirst($task->name)}}</a>
                        </div>
                    @empty
                        <div class="alert alert-success">Všechny věci jsou zapsané.</div>
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
