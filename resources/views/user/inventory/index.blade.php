@extends('user.layout.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h4>Sklady</h4>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                {{--                <a class="btn btn-sm btn-outline-secondary" href="{{route('admin.users.create')}}">+ Nový sklad</a>--}}
            </div>
        </div>
    </div>

    @if($places->count() == 0)
        <i>Ve vašich skupinách není k dispozici žádný sklad.</i>
    @else
        <p>Zobrazují se všechna dostupná skladová místa.</p>

        <table class="table table-striped"
               id="data-table">
            <thead>
            <tr>
                <th>Sklad</th>
                <th>Skupina</th>
            </tr>
            </thead>
            <tbody>
            @foreach($places as $place)
                <tr>
                    <td><a href="{{route('inventory.item_places.show', [$place->group, $place])}}">{{$place->name}}</a></td>
                    <td>{{$place->group->name}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
