@extends('inventory.layout.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <div>
            <h4>Nové skladové místo</h4>


            @if($parent_place)
                <p>Nadřazené místo: {{$parent_place->name}}</p>
            @endif
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                {{--                <a class="btn btn-sm btn-outline-secondary" href="{{route('admin.users.create')}}">+ Nový sklad</a>--}}
            </div>
        </div>
    </div>

    <form action="{{route('inventory.item_places.store', $group)}}"
          method="POST">
        @csrf

        @if($parent_place)
            <input type="hidden"
                   name="parent_id"
                   value="{{$parent_place->id}}">
        @endif

        <div class="form-group">
            <label>Název místa</label>
            <input class="form-control"
                   name="name">
        </div>

        <input type="submit"
               class="btn btn-primary">
    </form>

@endsection
