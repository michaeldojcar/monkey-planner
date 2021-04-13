@extends('inventory.layout.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <div>
            <h4>Úprava položky</h4>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                {{--                <a class="btn btn-sm btn-outline-secondary" href="{{route('admin.users.create')}}">+ Nový sklad</a>--}}
            </div>
        </div>
    </div>

    <form action="{{route('inventory.items.update', [$group, $item])}}"
          method="POST">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label>Název položky</label>
            <input class="form-control"
                   name="name"
                   value="{{$item->name}}"
                   required>
        </div>

        <div class="form-group"
             id="input_create_item">
            <label>Popis</label>
            <textarea class="form-control"
                      name="description">{{$item->description}}</textarea>
        </div>

        <div class="form-group">
            <label>Množstevní jednotka</label>
            <input class="form-control"
                   name="count_unit"
                   value="{{$item->count_unit}}"
                   required>
        </div>

        <input type="submit"
               class="btn btn-primary">

        <input type="submit"
               value="Odstranit"
               class="btn btn-danger"
               form="form_destroy"
               onclick="return confirm('Opravdu chcete odstranit tuto položku a všechna její data?')">
    </form>

    <form method="POST"
          action="{{route('inventory.items.destroy', [$group, $item])}}"
          id="form_destroy">
        @csrf
        @method('DELETE')
    </form>

@endsection
