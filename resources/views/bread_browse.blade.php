@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 style="margin-bottom: 10px">{{ucfirst($title)}}</h1>

        <div class="card">
            <div class="card-header">Výpis všech {{$title_genitiv}}</div>

            <div class="card-body">
                @if($collection->count() == 0)
                    <i>Žádné záznamy {{$title_genitiv}} nenalezeny</i>
                @else
                    <table class="table">
                        {{-- Výpis názvů sloupců --}}
                        @foreach($column_headers as $col_key => $col_th)
                            <th>
                                @if($sort_by == $columns[$col_key])
                                    @if($sort_way == "asc")
                                        <a style="color: black"
                                           href="{{url()->current()}}?sort_by={{$columns[$col_key]}}&sort_way=desc">{{$col_th}}</a>
                                        <i class="fas fa-chevron-up"></i>
                                    @else
                                        <a style="color: black"
                                           href="{{url()->current()}}?sort_by={{$columns[$col_key]}}&sort_way=asc">{{$col_th}}</a>
                                        <i class="fas fa-chevron-down"></i>
                                    @endif
                                @else
                                    <a style="color: grey"
                                       href="{{url()->current()}}?sort_by={{$columns[$col_key]}}&sort_way=asc">{{$col_th}}</a>
                                @endif
                            </th>
                        @endforeach

                        @foreach($collection as $record)
                            <tr>
                                @foreach($columns as $col_key => $col)
                                    @if($col_key == 0 || $col_key == 1)
                                        <td>
                                            <a href="{{url()->current()}}/edit/{{$record->id}}">{{$record->$col}}</a>
                                        </td>
                                    @else
                                        <td>
                                            {{$record->$col}}
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </table>

                    {{$collection->links()}}
                @endif
            </div>
        </div>
    </div>
@endsection