@extends('tabor_web.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <div>
            <h3>{{$day}}. den</h3>
            <p>{{$main_event->countDateFromThisEventsDayNumber($day)->format('d.m.Y')}}</p>
        </div>

        <div class="d-none d-md-block">
            <current-clock-widget></current-clock-widget>
        </div>

        {{--        <div class="btn-toolbar mb-2 mb-md-0">--}}
        {{--            <div class="btn-group mr-2 mt-2 mt-md-0">--}}
        {{--                <button class="btn btn-sm btn-success"--}}
        {{--                        data-toggle="modal"--}}
        {{--                        data-target="#exampleModal">--}}
        {{--                    <i class="fas fa-plus"></i> Nový blok programu--}}
        {{--                </button>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>

    <div class="mb-3">
        <h4>Program dne</h4>
    </div>

    <table class="table table-program">
        @forelse($events as $sub_event)
            {{--Hra--}}
            <?php $sub_event_class = '' ?>

            @if($sub_event->type == 3 ||$sub_event->type == 6)
                <?php $sub_event_class = 'muted' ?>
            @endif

            @if($sub_event instanceof \App\Event)
                <tr class="{{$sub_event_class}}">
                    <td width="60">{{$sub_event->from->format('H:i')}}</td>
                    <td width="120"
                        style="text-align: right">
                        {{ucfirst($sub_event->getTypeString())}}</td>
                    <td width="400">
                        <b>
                            <a href="{{route('organize.events.show', [$group, $sub_event])}}">{{mb_strtoupper($sub_event->name)}}</a>
                        </b>
                    </td>
                    <td>
                        @component('tabor_web.components.program.event_authors_hybrid', ['event' => $sub_event])@endcomponent
                    </td>
                </tr>
            @elseif($sub_event instanceof \App\EventTime)
                <tr class="{{$sub_event_class}}">
                    <td width="60">{{$sub_event->from->format('H:i')}}</td>
                    <td width="120"
                        style="text-align: right">
                        {{ucfirst($sub_event->event->getTypeString())}}</td>
                    <td width="400">
                        <b>
                            <a href="{{route('organize.events.show', [$group, $sub_event->event])}}">{{mb_strtoupper($sub_event->event->name)}}</a>
                        </b>
                    </td>
                    <td>
                        @component('tabor_web.components.program.event_authors_hybrid', ['event' => $sub_event->event])@endcomponent
                    </td>
                </tr>
            @endif

        @empty
            <tr>
                <td>-</td>
            </tr>
        @endforelse
    </table>

    {{--    <div class="mb-3 mt-5">--}}
    {{--        <h4>Podrobný program</h4>--}}
    {{--    </div>--}}
    {{--    @include('tabor_web.program.components.events')--}}


    {{-- Modal --}}
    {{--        @include('tabor_web.program.components.add_new_event_modal')--}}
@endsection
