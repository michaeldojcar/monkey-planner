@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <a href="{{route('admin.groups.index')}}"
           class="btn btn-secondary float-right">Storno</a>

        <h4 class="mb-4">Nový tým</h4>

        <form method="POST"
              action="{{route('admin.groups.store')}}">
            @csrf

            <div class="form-group">
                <input type="text"
                       name="name"
                       class="form-control"
                       placeholder="Název týmu">
            </div>

            <input class="btn btn-success"
                   value="Vytvořit"
                   type="submit">
        </form>
    </div>
@endsection
