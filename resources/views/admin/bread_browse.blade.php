@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Výpis všech {{$title_genitiv}}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a class="btn btn-sm btn-outline-secondary" href="{{route($route_add)}}">+ Nový {{$title_single}}</a>
            </div>
        </div>
    </div>


    @if($collection->count() == 0)
        <i>Žádné záznamy {{$title_genitiv}} nebyly nalezeny.</i>
    @else
        <table class="table table-striped">
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

            {{-- Výpis položek --}}
            @foreach($collection as $record)
                <tr>
                    @foreach($columns as $col_key => $col)
                        {{-- Položka s odkazem na single zobrazení --}}
                        @if($col_key == 0)
                            <td>
                                <a href="{{ route($route_edit, ['id' => $record->id]) }}">{{$record->$col}}</a>
                            </td>
                        @else
                            @if(isset($columns_complete_array[$col_key]['strings']))
                                {{-- Pokud je definované, vypíše stringové case pojmenování --}}

                                <td>
                                    {{$columns_complete_array[$col_key]['strings'][$record->$col]}}
                                </td>

                            @else
                                {{-- Jinak vrátí pouze hodnotu položky --}}
                                <td>
                                    @if(isset($columns_complete_array[$col_key]['string_suffix']))
                                        {{$record->$col}} {{ $columns_complete_array[$col_key]['string_suffix'] }}
                                    @else
                                        {{$record->$col}}
                                    @endif
                                </td>
                            @endif
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </table>

        {{ $collection->links() }}
    @endif
@endsection
