@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Skupiny ve farnosti</h1>
    </div>

    <table>
        @foreach($groups as $group)
            <tr>
                <td>{{$group->name}}</td>
            </tr>
        @endforeach
    </table>
@endsection
