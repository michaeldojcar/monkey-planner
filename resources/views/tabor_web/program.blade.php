@extends('tabor_web.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">{{$main_event->name}}</h1>
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
                        <td colspan="2">Celotáborové aktivity + prvky mimo program</td>
                    </tr>

                    @foreach($non_scheduled as $sub_event)
                        <tr>
                            <td style="width: 200px">
                                <a href="{{route('organize.event', [$group, $sub_event])}}">{{$sub_event->name}}</a>
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

    <div class="table-responsive material-shadow">
        <table class="table"
               style="border-top: black 1px solid !important;">
            <tr class="table-header">
                <td width="40"><span class="d-none d-sm-block">Den</span><span class="d-block d-sm-none">#</span></td>
                <td width="80">Datum</td>
                <td>Program</td>
            </tr>
            @foreach($days as $key => $day)
                <tr style="border-bottom: 2px black solid">
                    <td>{{$key}}.</td>
                    <td>@switch($main_event->countDateFromThisEventsDayNumber($key)->dayOfWeek)
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
                        {{$main_event->countDateFromThisEventsDayNumber($key)->format('j.n.')}}</td>
                    <td style="padding: 0">
                        <table class="table-inner">
                            @forelse($day as $sub_event)
                                {{--Hra--}}
                                <?php $sub_event_class = '' ?>

                                @if($sub_event->type == 3 ||$sub_event->type == 6)
                                    <?php $sub_event_class = 'muted' ?>
                                @endif
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
                            @empty
                                <tr>
                                    <td>-</td>
                                </tr>
                            @endforelse
                        </table>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade"
         id="exampleModal"
         tabindex="-1"
         role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog"
             role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="exampleModalLabel">Nový blok programu</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST"
                      action="{{route('organize.program', $main_event)}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="name"
                                   class="col-4 col-form-label">Název</label>
                            <div class="col-8">
                                <input id="name"
                                       name="name"
                                       type="text"
                                       class="form-control"
                                       required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="select"
                                   class="col-4 col-form-label">Typ programu</label>
                            <div class="col-8">
                                <select id="type"
                                        name="type"
                                        class="custom-select"
                                        required="required">
                                    <option value="0">Událost</option>
                                    <option value="1">Hra</option>
                                    <option value="2">Program</option>
                                    <option value="3">Režim</option>
                                    <option value="4">Přednáška</option>
                                    <option value="5">Duchovní</option>
                                    <option value="6">Scénka</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="select1"
                                   class="col-4 col-form-label">Den</label>
                            <div class="col-8">
                                <select id="day"
                                        name="day"
                                        class="custom-select">
                                    @for($x = 0; $x <= $days_count; $x++)
                                        <option value="{{$x}}">{{$x}}.
                                            den @switch($main_event->countDateFromThisEventsDayNumber($x)->dayOfWeek)
                                                @case(0)
                                                <span>(NE)</span>
                                                @break
                                                @case(1)
                                                <span>(PO)</span>
                                                @break
                                                @case(2)
                                                <span>(ÚT)</span>
                                                @break
                                                @case(3)
                                                <span>(ST)</span>
                                                @break
                                                @case(4)
                                                <span>(ČT)</span>
                                                @break
                                                @case(5)
                                                <span>(PÁ)</span>
                                                @break
                                                @case(6)
                                                <span>(SO)</span>
                                                @break
                                            @endswitch
                                        </option>
                                    @endfor
                                    <option value="all">Každý den</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="select2"
                                   class="col-4 col-form-label">Hrubé umístění ve dni</label>
                            <div class="col-8">
                                <select id="time"
                                        name="time"
                                        class="custom-select">
                                    <option value="7:00">7:00</option>
                                    <option value="8:00">8:00</option>
                                    <option value="9:00">9:00</option>
                                    <option value="10:00">10:00</option>
                                    <option value="11:00">11:00</option>
                                    <option value="12:00">12:00</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:00">14:00</option>
                                    <option value="15:00">15:00</option>
                                    <option value="16:00">16:00</option>
                                    <option value="17:00">17:00</option>
                                    <option value="18:00">18:00</option>
                                    <option value="19:00">19:00</option>
                                    <option value="20:00">20:00</option>
                                    <option value="21:00">21:00</option>
                                    <option value="22:00">22:00</option>
                                    <option value="23:00">23:00</option>
                                    <option value="0:00">0:00</option>
                                    <option value="1:00">1:00</option>
                                    <option value="2:00">2:00</option>
                                    <option value="3:00">3:00</option>
                                    <option value="4:00">4:00</option>
                                    <option value="5:00">5:00</option>
                                    <option value="6:00">6:00</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal">Zavřít
                        </button>
                        <button name="submit"
                                type="submit"
                                class="btn btn-primary">Přidat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
