<div style="page-break-inside: avoid">
    @if($event->is_scheduled)
        <p style="font-size: 24px;">{{$event->from->format("H:i")}} - {{$event->to->format("H:i")}}
            ({{ $event->to->diffInHours($event->from) ? $event->to->diffInHours($event->from) . ' h' : $event->to->diffInMinutes($event->from) . ' minut'}})</p>
    @endif


    <table style="margin-bottom: 15px;">
        <tr class="table-header text-center">
            <td>
                <h2 style="margin: 7px">
                    @if($event->is_scheduled)
                        {{$event->getTypeString()}}:
                    @endif
                    {{$event->name}}</h2>
            </td>
        </tr>
        <tr>
            <td>
                <table style="margin-top: 10px; text-align: center; margin-bottom: 10px;">
                    <tr>
                        @if($event->place)
                            <td class="td-dark"
                                width="33%">Místo
                            </td>
                        @endif
                        <td class="td-dark"
                            width="33%">Autor
                        </td>
                        <td class="td-dark"
                            width="33%">Garant
                        </td>
                    </tr>
                    <tr style="height: 20px">
                        @if($event->place)
                            <td>{{$event->place}}</td>
                        @endif
                        <td>@component('tabor_web.components.event.authors', ['event' => $event])@endcomponent</td>
                        <td>@component('tabor_web.components.event.garants', ['event' => $event])@endcomponent</td>
                    </tr>
                </table>

                <table>
                    @foreach($event->blocks as $block)
                        <tr style="min-height: 30px; font-size: 18px !important;">
                            <td class="td-dark"
                                style="width: 100px;">{{$block->title}}</td>
                            <td style="font-size: 18px !important">{!! $block->content !!}</td>
                        </tr>
                    @endforeach
                </table>

                @if($event->roleTasks()->where('content','!=', null)->count())
                    <div class="">
                        <h3>Info pro konkrétní role</h3>
                    </div>

                    @foreach($event->roleTasks as $task)
                        @if(isset($task->content))
                            <table style="margin-bottom: 9px; page-break-inside: avoid; font-size: 18px !important">
                                <tr>
                                    <td style="background-color: #c9ffaf; color: black; font-size: 18px !important"><b>{{$task->name}}</b>
                                        - @include('tabor_web.components.event.role_garants')</td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! $task->content !!}
                                    </td>
                                </tr>
                            </table>
                        @endif
                    @endforeach

                    <div class="row">
                        <div class="col-6">
                            <h3>Další úkoly</h3>

                            @foreach($event->basicTasks as $task)
                                @if(isset($task->content))
                                    <table style="margin-bottom: 9px; page-break-inside: avoid; font-size: 18px !important">
                                        <tr>
                                            <td style="background-color: #c9ffaf; font-weight: bold; color: black; font-size: 18px !important">{{$task->name}}
                                                - @include('tabor_web.components.event.role_garants')</td>
                                        </tr>
                                        @if(!empty($task->content))
                                            <tr>
                                                <td>
                                                    {!! $task->content !!}
                                                </td>
                                            </tr>
                                        @endif
                                    </table>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-6">
                            <h3>Potřebné věci</h3>

                            @foreach($event->itemTasks as $task)
                                <table style="margin-bottom: 9px; page-break-inside: avoid; font-size: 18px !important">
                                    <tr>
                                        <td style="background-color: #c9ffaf; color: black; font-size: 18px !important"><b>{{$task->name}}</b>
                                            - @include('tabor_web.components.task.garant_users')</td>
                                    </tr>
                                    @if(!empty($task->content))
                                        <tr>
                                            <td>
                                                {!! $task->content !!}
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            @endforeach
                        </div>
                    </div>
                @endif
            </td>
        </tr>
    </table>
</div>
