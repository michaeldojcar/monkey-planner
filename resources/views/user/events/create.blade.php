@extends('user.layout.layout')

@section('content')
    <div class="container-fluid">
        <a href=""
           class="btn btn-success float-right">Storno</a>

        <h4 class="mb-4">Nová akce</h4>

        <form method="POST"
              action="{{route('user.events.store')}}">
            @csrf

            <div class="form-group">
                <input type="text"
                       name="name"
                       class="form-control"
                       placeholder="Název akce">
            </div>

            <div class="form-group">
                <label>Team</label>

                <select name="owner_group_id"
                        class="form-control">
                    @foreach($groups as $group)
                        <option value="{{$group->id}}">{{$group->name}}</option>
                    @endforeach
                </select>
            </div>

            <input class="btn btn-success"
                   value="Vytvořit akci"
                   type="submit">
        </form>
    </div>
@endsection
