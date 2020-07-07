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

    <style>
        .table {
            border: 1px #0c0c0c solid;
            color: #333;
            background-color: #f8f9fa;
        }


        .table td {
            border: 1px #0c0c0c solid;
            padding: 9px;
        }


        .table-header {
            background-color: #512da8;
            color: white;
            font-weight: bold;
        }


        .table-header-dark {
            background-color: #282828;
            color: white;
            font-weight: bold;
        }


        .table-inner {
            margin: 0;
            width: 100%;
            height: 0;
        }


        .table-inner tr {
            border: none;
        }


        .table-inner td {
            border-bottom: 1px #0c0c0c solid;
        }


        .table-inner {
            border-collapse: collapse;
        }


        .table-inner td {
            border: 1px #0c0c0c solid;
        }


        .table-inner tr:first-child td {
            border-top: 0;
        }


        .table-inner tr td:first-child {
            border-left: 0;
        }


        .table-inner tr:last-child td {
            border-bottom: 0;
        }


        .table-inner tr td:last-child {
            border-right: 0;
        }


        table a {
            color: black;
            text-decoration: none;
        }


        .muted td {
            font-size: 10px;
            padding: 4px 9px;
        }


        .muted a, .muted td {
            color: #444444;
        }
    </style>

    <div class="row">
        @if($main_event->content)
            <div class="col-sm">
                <div class="card">
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
                <table class="table material-shadow">
                    <tr class="table-header-dark">
                        <td colspan="2">Další části programu</td>
                    </tr>

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
