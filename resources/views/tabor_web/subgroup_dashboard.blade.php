@extends('tabor_web.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <div><span style="text-transform: uppercase">PŘÍPRAVNÝ TEAM</span>
            <h1 class="h2">{{$subgroup->name}}</h1></div>
        {{--<div class="btn-toolbar mb-2 mb-md-0">--}}
        {{--<div class="btn-group mr-2">--}}
        {{--<a class="btn btn-sm btn-outline-secondary" href="{{route('organize.program',$group)}}">--}}
        {{--<i class="fas fa-arrow-alt-circle-left"></i> Návrat na program--}}
        {{--</a>--}}
        {{--</div>--}}
        {{--</div>--}}
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card mb-3">
                <div class="card-header">Členové týmu</div>
                <div class="card-body">
                    {{ $subgroup->sayMembersCount() }}:
                    @foreach($subgroup->users as $user)
                        <span style="font-weight: bold; color: blue">{{ mb_strtoupper($user->name) }} {{mb_substr($user->surname, 0, 1)}}.</span>{{ $loop->last ? '' : ', ' }}
                    @endforeach
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Bloky programu - {{$subgroup->name }}</div>

                <div class="table-responsive">
                    <table class="table table-striped"
                           style="margin-bottom: 0">
                        <th>Den</th>
                        <th>Název</th>
                        <th>Má na starost</th>
                        @foreach($group_events->sortBy('from') as $event)
                            <tr>
                                <td>{{$event->getDayNumber()}}. DEN</td>
                                <td><a href="{{route('organize.event', [$group, $event])}}">{{$event->name}}</a></td>
                                <td>
                                    @include('tabor_web.components.program.event_authors_hybrid')
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>

            </div>

            <div class="card">
                <div class="card-header">Soukromá info-vlákna týmu

                    <div style="float: right;">
                        {{--<a class="btn btn-sm btn-outline-primary">Změnit nastavení</a>--}}
                        <button class="btn btn-sm btn-success"
                                data-toggle="modal"
                                data-target="#exampleModal">
                            <i class="fas fa-plus"></i> Nové vlákno
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($subgroup->blocks()->orderBy('updated_at','desc')->get() as $block)
                        <div class="card"
                             style="margin-bottom: 7px">
                            <div class="card-header card-header-black"
                                 data-toggle="collapse"
                                 href="#block{{$block->id}}body">{{$block->title}}

                                <div style="float: right">
                                    <a href="{{route('organize.block.edit', ['group'=>$group, 'block'=>$block])}}"><i
                                                class="fas fa-edit"
                                                style="color: white"></i></a>
                                </div>
                            </div>

                            <div class="collapse"
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

                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">Úkoly - {{$subgroup->name }}</div>

                <div class="table-responsive">
                    <table class="table table-striped"
                           style="margin-bottom: 0">
                        <th>Název</th>
                        <th>Má na starost</th>

                        @foreach($group_tasks as $task)
                            <tr>
                                <td><a href="{{route('organize.task',[$group, $task])}}">{{ucfirst($task->name)}}</a>
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

        {{--        <div class="col-sm">--}}
        {{--            <div class="card">--}}
        {{--                <div class="card-header">Možnosti týmu</div>--}}
        {{--                <div class="card-body">--}}
        {{--                    --}}{{--<a class="btn btn-primary">Úkoly týmu</a>--}}
        {{--                    @if(isset($subgroup->chat))--}}
        {{--                        <a target="_blank" class="btn btn-primary" href="{{$subgroup->chat}}"><i--}}
        {{--                                    data-feather="message-circle"></i>--}}
        {{--                            Otevřít chat</a>--}}
        {{--                    @endif--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>

    <style>
        .card-header-black {
            background-color: #343940;
            color:            #e9e9e9;
            font-weight:      bold;
            padding:          8px 12px;
        }
    </style>


    @include('tabor_web.components.subgroup.new_block')
@endsection

@section('scripts')

    @include('tabor_web.tasks.cycleJs')

@endsection