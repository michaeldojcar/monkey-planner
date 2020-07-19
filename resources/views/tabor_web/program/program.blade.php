@extends('tabor_web.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h3>{{$main_event->name}} - program</h3>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{route('organize.program.print.index', [$group])}}"
               class="btn btn-sm btn-primary mr-2"><i class="fas fa-print"></i> Verze pro tisk</a>
            <a href="{{route('organize.events.edit', [$group, $main_event])}}"
               class="btn btn-sm btn-warning mr-2">Upravit hlavní událost</a>

            <div class="btn-group mr-2 mt-2 mt-md-0">
                <button class="btn btn-sm btn-success"
                        data-toggle="modal"
                        data-target="#exampleModal">
                    <i class="fas fa-plus"></i> Nový blok programu
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        @if($main_event->content)
            <div class="col-sm">
                <div class="card card-block">
                    <div class="card-header">
                        Základní informace
                    </div>
                    <div class="card-body">
                        {!! $main_event->content !!}
                    </div>
                </div>
            </div>
        @endif

        @if($non_scheduled->count())
            <div class="col-sm">
                <div class="card card-block">
                    <div class="card-header">Hlavní bloky</div>
                    <div class="card-body">
                        <table class="table">
                            @foreach($non_scheduled as $sub_event)
                                <tr>
                                    <td style="width: 200px">
                                        <a href="{{route('organize.events.show', [$main_event, $sub_event])}}">{{$sub_event->name}}</a>
                                    </td>
                                    <td>@component('tabor_web.components.program.event_authors_hybrid', ['event' => $sub_event])@endcomponent</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="mb-3">
        <h3>Program</h3>
    </div>

    @include('tabor_web.program.components.summary')

    {{--    <div class="mb-3 mt-5">--}}
    {{--        <h4>Podrobný program</h4>--}}
    {{--    </div>--}}
    {{--    @include('tabor_web.program.components.events')--}}


    {{-- Modal --}}
    @include('tabor_web.program.components.add_new_event_modal')
@endsection
