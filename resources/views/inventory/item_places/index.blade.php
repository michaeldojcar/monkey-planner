@extends('inventory.layout.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h4>{{$group->name}} - skladová místa</h4>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a class="btn btn-sm btn-outline-secondary"
                   href="{{route('inventory.item_places.create', [$group])}}">+ Nové místo</a>
            </div>
        </div>
    </div>

    @if($places->count() > 0)
        <table class="table table-striped"
               id="data-table">
            <thead>
            <tr>
                <th>Název</th>
            </tr>
            </thead>
            <tbody>
            @foreach($places as $place)
                <tr>
                    <td><a href="{{route('inventory.item_places.show', [$group, $place])}}">{{$place->name}}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
