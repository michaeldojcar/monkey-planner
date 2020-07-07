@extends('user.layout.layout')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">Moje týmy</h4>

        <table class="table">
            <tr>
                <th>Název</th>
            </tr>
            @foreach($groups as $group)
                <tr>
                    <td><a href="">{{$group->name}}</a></td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
