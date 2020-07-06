@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Úprava {{ $strings['name_2p'] }} {{ $object->{$rows[0]['name'] } }}</h1>
    </div>

    <div class="container-fluid">

        <form method="post" action="{{route($route_store_edit)}}">
            @csrf
            <input type="hidden" name="bread_id" value="{{$object->id}}">

            <div class="row">
                <div class="col-7">
                    <div class="card">
                        <div class="card-header">Údaje {{ $strings['name_2p'] }}</div>
                        <div class="card-body">
                            @include('admin.bread_form')
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="card">
                        <div class="card-header">Možnosti</div>
                        <div class="card-body">
                            <input type="submit" class="btn btn-primary" value="Uložit změny">
                            <a class="btn btn-warning" href="{{route($route_browse)}}"
                               onclick="return confirm('Pozor! Při stornu nebudu úpravy {{$strings['name_2p']}} {{ $object->{$rows[0]['name'] } }} uloženy. Chcete pokračovat?')">Storno</a>
                        </div>
                    </div>
                </div>
                @section('custom_props')

                @endsection
            </div>
        </form>

    </div>
@endsection
