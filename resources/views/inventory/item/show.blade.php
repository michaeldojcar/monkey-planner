@extends('inventory.layout.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <div>
            <h4>{{$item->name}}</h4>

            <p>
                <a href="{{route('inventory.item_places.index', $group)}}">{{$group->name}}</a>

                {{--                @if($place->parent_item_place)--}}
                {{--                    → <a href="{{route('inventory.item_places.show', ['group_id' => $place->group, $place->parent_place_id])}}">{{$place->parent_item_place->name}}</a>--}}
                {{--                @endif--}}

                → {{$item->name}}
            </p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                {{--                <a class="btn btn-sm btn-outline-secondary"--}}
                {{--                   href="{{route('inventory.item_places.create', [$group, 'parent_id'=>$place->id])}}">+ Nové místo</a>--}}

                {{--                <a class="btn btn-sm btn-outline-secondary"--}}
                {{--                   href="{{route('inventory.items.create', [$group, 'place_id'=>$place])}}">+ Nová položka</a>--}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <h5>Umístění</h5>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Místo</th>
                    <th>Množství</th>
                </tr>
                </thead>
                <tbody>
                @foreach($item->item_states as $state)
                    <tr>
                        <td><a href="{{route('inventory.item_places.show', [$group, $state->item_place])}}">{{$state->item_place->name}}</a></td>
                        <td>{{$state->count}} {{$item->count_unit}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
{{--            @if($item->photo->count())--}}

{{--            @endif--}}
        </div>
    </div>
@endsection
