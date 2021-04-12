@extends('inventory.layout.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <div>
            <h4>{{$place->name}}</h4>

            <p>
                <a href="{{route('inventory.item_places.index', $place->group)}}">{{$place->group->name}}</a>

{{--                @if($place->parent_item_place)--}}
{{--                    → <a href="{{route('inventory.item_places.show', ['group_id' => $place->group, $place->parent_place_id])}}">{{$place->parent_item_place->name}}</a>--}}
{{--                @endif--}}

                → {{$place->name}}
            </p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a class="btn btn-sm btn-outline-secondary"
                   href="{{route('inventory.item_places.create', [$group, 'parent_id'=>$place->id])}}">+ Nové místo</a>
            </div>
        </div>
    </div>

    @if($place->item_places()->count() > 0)
        <h5>Skladová místa</h5>

        <table class="table table-striped"
               id="data-table">
            <thead>
            <tr>
                <th>Skladové místo</th>
            </tr>
            </thead>
            <tbody>
            @foreach($place->item_places as $subplace)
                <tr>
                    <td><a href="{{route('inventory.item_places.show', [$group, $subplace])}}">{{$subplace->name}}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
