@extends('user.layout.layout')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">Moje skupiny</h4>

        <table class="table table-striped" id="data-table">
            <thead>
            <tr>
                <th>Název</th>
                <th>Počet členů</th>
            </tr>
            </thead>
            <tbody>
            @foreach($groups as $group)
                <tr>
                    <td><a href="">{{$group->name}}</a></td>
                    <td>{{$group->users()->count()}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
