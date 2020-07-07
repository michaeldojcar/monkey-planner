@extends('admin.layout')

@section('content')
    <a class="btn btn-success float-right" href="{{route('admin.groups.create')}}">Nový tým</a>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h3>Týmy</h3>
    </div>

    <table class="table table-striped">
        <tr>
            <th>Název</th>
        </tr>

        @foreach($groups as $group)
            <tr>
                <td><a href="{{route('admin.groups.show', $group)}}">{{$group->name}}</a></td>
            </tr>
        @endforeach
    </table>
@endsection
