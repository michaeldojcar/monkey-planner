@extends('user.layout.layout')

@section('content')
    <div class="container-fluid">

        <a href="{{route('user.events.create')}}"
           class="btn btn-success float-right">Přidat událost</a>

        <h4 class="mb-4">Nadcházející události</h4>

        <table class="table table-striped">
            <tr>
                <th>Název</th>
                <th>Termín</th>
                <th>Skupina</th>
            </tr>
            @foreach($upcoming_events as $event)
                <tr>
                    <td><a href="{{route('organize.dashboard', $event)}}">{{$event->name}}</a></td>
                    <td>{{ Carbon\Carbon::parse($event->from)->format('d.m.Y H:i') }}
                        ({{ Carbon\Carbon::parse($event->from)->diffForHumans() }})
                    </td>
                    <td>{{ $event->owner_group->name }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
