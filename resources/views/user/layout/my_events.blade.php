@extends('user.layout.layout')

@section('content')
    <div class="container-fluid">
        <a href="" class="btn btn-success float-right">Vytvořit akci</a>

        <h4 class="mb-4">Moje akce</h4>

        <table class="table">
            <tr>
                <th>Název</th>
                <th>Termín</th>
                <th>Skupina</th>
            </tr>
            @foreach($events as $event)
                <tr>
                    <td><a href="">{{$event->name}}</a></td>
                    <td>{{ Carbon\Carbon::parse($event->from)->format('H:i d.m.') }}
                        ({{ Carbon\Carbon::parse($event->from)->diffForHumans() }})
                    </td>
                    <td>{{ $event->owner_group->name }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
