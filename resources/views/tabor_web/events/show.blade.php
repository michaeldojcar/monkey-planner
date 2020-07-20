@extends('tabor_web.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <div><span style="text-transform: uppercase">{{$event->getTypeString()}} {{$event->getTypeEmoji()}}</span>
            <h1 class="h2">{{$event->name}}</h1></div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a class="btn btn-sm btn-warning"
                   style="margin-right: 1em"
                   href="{{route('organize.events.edit', [$main_event, $event])}}">
                    <i class="fas fa-calendar"></i> Upravit událost
                </a>

                <a class="btn btn-sm btn-primary"
                   href="{{route('organize.program', $group)}}">
                    <i class="fas fa-arrow-alt-circle-left"></i> Zobrazit v programu
                </a>
            </div>

            @if($event->is_scheduled)
                {{--                <div class="btn-group mr-2">--}}
                {{--                    <a class="btn btn-sm btn-success {{ $event->getPreviousSubEvent() ? '' : 'disabled' }}"--}}
                {{--                       href="{{route('organize.event', ['main_event'=>$main_event,'event'=> $event->getPreviousSubEvent()]) }}">--}}
                {{--                        <i class="fas fa-arrow-alt-circle-left"></i>--}}
                {{--                    </a>--}}
                {{--                    <a class="btn btn-sm btn-success {{ $event->getNextSubEvent() ? '' : 'disabled' }}"--}}
                {{--                       href="{{route('organize.event', ['main_event'$main_event , $event->getNextSubEvent()])}}">--}}
                {{--                        <i class="fas fa-arrow-alt-circle-right"></i>--}}
                {{--                    </a>--}}
                {{--                </div>--}}
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-6">
                    <table class="table table-black">
                        <tr>

                            <td width="150"
                                class="td-title">Datum
                            </td>
                            <td>
                                @if($event->is_scheduled)
                                    @if(!$event->has_multiple_times)
                                        @switch($event->from->dayOfWeek)
                                            @case(0)
                                            <span>NE</span>
                                            @break
                                            @case(1)
                                            <span>PO</span>
                                            @break
                                            @case(2)
                                            <span>ÚT</span>
                                            @break
                                            @case(3)
                                            <span>ST</span>
                                            @break
                                            @case(4)
                                            <span>ČT</span>
                                            @break
                                            @case(5)
                                            <span>PÁ</span>
                                            @break
                                            @case(6)
                                            <span>SO</span>
                                            @break
                                        @endswitch

                                        {{$event->from->format('j.n.')}} ({{$event->getDayNumber()}}. den)
                                    @else
                                        více výskytů
                                    @endif
                                @else
                                    -
                                @endif
                            </td>

                        </tr>
                        <tr>
                            <td class="td-title">Předpokládaný čas</td>
                            <td>
                                @if($event->is_scheduled)
                                    @if($event->has_multiple_times)
                                        více výskytů
                                    @else
                                        {{$event->from->format('G:i')}} - {{$event->to->format('G:i')}}
                                        ({{$event->to->diffInHours($event->from)}} h)
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-sm-6">
                    <table class="table table-black">
                        <tr>
                            <td width="100"
                                class="td-title">Autor <i class="fa fa-user"></i></td>
                            <td>@component('tabor_web.components.event.authors', ['event' => $event])@endcomponent</td>
                        </tr>
                        <tr>
                            <td class="td-title">Garant <i class="fa fa-user-shield"></i></td>
                            <td>@component('tabor_web.components.event.garants', ['event' => $event])@endcomponent</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{--<textarea class="textarea-content"></textarea>--}}
            @foreach($event->blocks as $block)
                <div class="card card-block">
                    <div class="card-header"
                         data-toggle="collapse"
                         href="#block{{$block->id}}body">{{$block->title}}

                        <div style="float: right">
                            <a href="{{route('organize.blocks.edit', ['event' => $main_event, 'block' => $block])}}"><i
                                    class="fas fa-edit"
                                    style="color: white"></i></a>
                        </div>
                    </div>

                    <div class="collapse show"
                         id="block{{$block->id}}body">
                        <div class="card-body">
                            @if($block->content)
                                {!! $block->content !!}
                            @else
                                <span style="font-weight: bold; color: red">???</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            <div style="text-align: right; margin: 10px 0 20px">
                {{--<a class="btn btn-sm btn-outline-primary">Změnit nastavení</a>--}}
                <button class="btn btn-sm btn-success"
                        data-toggle="modal"
                        data-target="#exampleModal">
                    <i class="fas fa-plus"></i> Nová sekce
                </button>
            </div>

            @if($event->roleTasks()->count() > 0)
                <div class="mb-3">
                    <h5>Info pro konkrétní role</h5>
                </div>

                @foreach($event->roleTasks as $task)
                    @if(isset($task->content))
                        <div class="card mb-3">
                            <div class="card-header"
                                 data-toggle="collapse"
                                 href="#task{{$task->id}}body"
                                 style="background-color: #b0ccb2; color: black">{{$task->name}}
                                - @include('tabor_web.components.event.role_garants')

                                <div style="float: right">
                                    <a href="{{route('organize.tasks.show', ['event' => $main_event, 'task' => $task])}}"><i
                                            class="fas fa-edit"
                                            style="color: white"></i></a>
                                </div>
                            </div>

                            <div class="collapse show"
                                 id="task{{$task->id}}body">
                                <div class="card-body">
                                    @if($task->content)
                                        {!! $task->content !!}
                                    @else
                                        <span style="font-weight: bold; color: red">???</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
        <div class="col-sm-4">
            @if(!empty($event->place))
                <table class="table">
                    <tr>
                        <td class="text-success">
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            <span class="font-weight-bolder">{{ $event->place }}</span>
                        </td>
                    </tr>
                </table>
            @endif

            <div class="card card-block">
                <div class="card-header">Role
                    <a style="float: right"
                       data-toggle="modal"
                       data-target="#userAssignModal"><i
                            class="fa fa-plus"></i></a>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($event->roleTasks as $task)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{route('organize.tasks.edit', [$main_event, $task])}}">{{ucfirst($task->name)}}</a>
                                @include('tabor_web.components.event.role_garants')
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="card card-block">
                <div class="card-header">Úkoly
                    <a style="float:right"><i class="fa fa-plus"
                                              data-target="#taskAssignModal"
                                              data-toggle="modal"></i></a>
                </div>
                <div class="card-body">

                    <table style="width: 100%;">


                        <ul class="list-group">
                            @foreach($event->basicTasks as $task)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{route('organize.tasks.show', [$main_event, $task])}}">{{ucfirst($task->name)}}</a>

                                    <div>
                                        @include('tabor_web.components.task.garants')
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </table>
                </div>
            </div>

            <div class="card card-block">
                <div class="card-header">Potřebné věci
                    <a style="float:right"><i class="fa fa-plus"
                                              data-target="#itemTaskAssignModal"
                                              data-toggle="modal"></i></a>
                </div>
                <div class="card-body">

                    <table style="width: 100%;">
                        <ul class="list-group">
                            @foreach($event->itemTasks as $task)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                   <span>
                                       <b>{{$task->required_count}}x</b>
                                       <a href="{{route('organize.tasks.show', [$group, $task])}}">{{ucfirst($task->name)}}</a>
                                   </span>

                                    <div>
                                        @include('tabor_web.components.task.garants')
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </table>
                </div>
            </div>

            @if($event->has_multiple_times)

                <div class="card card-block">
                    <div class="card-header">Výskyty bloku
                        <a style="float: right; color: white"
                           href="{{route('organize.event_times.create', $event->id)}}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($event->event_times->sortBy('from') as $event_time)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{$event_time->getDayNumber()}}. den {{$event_time->from->format('H:i')}}

                                    @if($event_time->event->event_times->count() > 1)
                                        <a class="text-black-50"
                                           href="{{route('organize.event_times.destroy', $event_time)}}"
                                           onclick="return confirm('Opravdu chcete smazat tento výskyt {{$event->name}}?')"><i class="fas fa-trash"></i></a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    @include('tabor_web.components.event.new_block')
    @include('tabor_web.components.event.role_task_assign')
    @include('tabor_web.components.event.basic_task_assign')
    @include('tabor_web.components.event.item_task_assign')

@endsection

@push('scripts')

    @include('tabor_web.tasks.cycleJs')

    @if($event->is_scheduled)
        <script type="text/javascript">
            $(document).keyup(function (e) {

                {{--                @if(! empty($event->getPreviousSubEvent()))--}}
                {{--                // CTRL + left arrow--}}
                {{--                if (e.ctrlKey && e.keyCode === 37) {--}}
                {{--                    window.location = "{{route('organize.event', [$main_event, $event->getPreviousSubEvent()])}}";--}}
                {{--                }--}}
                {{--                @endif--}}

                {{--                @if(! empty($event->getNextSubEvent()))--}}
                {{--                // CTRL + right arrow--}}
                {{--                if (e.ctrlKey && e.keyCode === 39) {--}}
                {{--                    window.location = "{{route('organize.event', [$main_event, $event->getNextSubEvent()])}}";--}}
                {{--                }--}}
                {{--                @endif--}}
            });
        </script>
    @endif

@endpush
