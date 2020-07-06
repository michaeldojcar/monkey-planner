@extends('admin.layout')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Nový {{ $strings['name'] }}</h1>
        </div>

        <form method="post" action="{{route($route_store_add)}}">
            @csrf
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
                        <div class="card-header">Možnosti nového {{$strings['name_2p']}}</div>
                        <div class="card-body">
                            <input type="submit" class="btn btn-primary" value="Vytvořit {{$strings['name_4p']}}">
                            <a class="btn btn-warning" href="{{route($route_browse)}}"
                               onclick="return confirm('Pozor! Při stornu nebude záznam nového {{$strings['name_2p']}} vytvořen. Chcete pokračovat?')">Storno</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection
