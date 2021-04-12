@extends('inventory.layout.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h4>{{$place->name}} - {{$place->group->name}}</h4>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                {{--                <a class="btn btn-sm btn-outline-secondary" href="{{route('admin.users.create')}}">+ Nový sklad</a>--}}
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
                    <td><a href="{{route('user.inventories.show', $subplace)}}">{{$subplace->name}}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
