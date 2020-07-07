@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h3>Uživatelé</h3>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a class="btn btn-sm btn-outline-secondary" href="{{route('admin.users.create')}}">+ Nový uživatel</a>
            </div>
        </div>
    </div>


    @if($users->count() == 0)
        <i>Žádní uživatelé nebyli nalezeni.</i>
    @else
        <table class="table table-striped" id="data-table">
            <thead>
            <tr>
                <th>Uživatelské jméno</th>
                <th>Email</th>
                <th>Mobil</th>
                <th>Adresa</th>
            </tr>
            </thead>

            <tbody>
            {{-- Výpis položek --}}
            @foreach($users as $user)
                <tr>
                    <td><a href="{{route('admin.users.edit', $user->id)}}">{{$user->getWholeName()}}</a></td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->street}}<br>{{$user->town}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
