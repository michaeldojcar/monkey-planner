@extends('inventory.layout.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h4>Inventář - {{$main_group->name}}</h4>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                {{--                <a class="btn btn-sm btn-outline-secondary" href="{{route('admin.users.create')}}">+ Nový sklad</a>--}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h5>Položky</h5>
            <table class="table">
                <tr>
                    <td class="w-75">Položky</td>
                    <td>{{$item_count}}</td>
                </tr>
            </table>

            <h5>Místa</h5>
            <table class="table">
                <tr>
                    <td class="w-75">Sklady</td>
                    <td>{{$main_place_count}}</td>
                </tr>
                <tr>
                    <td>Skladová místa</td>
                    <td>{{$place_count}}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
