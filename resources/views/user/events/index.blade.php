@extends('user.layout.layout')

@section('content')
    <div class="container-fluid">
        <a href="{{route('user.events.create')}}"
           class="btn btn-success float-right">Vytvořit akci</a>

        <h4 class="mb-4">Moje akce</h4>

        <table class="table table-striped">
            <tr>
                <th>Název</th>
                <th>Termín</th>
                <th>Skupina</th>
            </tr>
            @foreach($upcoming_events as $event)
                <tr>
                    <td><a href="{{route('organize.dashboard', $event)}}">{{$event->name}}</a></td>
                    <td>{{ Carbon\Carbon::parse($event->from)->format('H:i d.m.') }}
                        ({{ Carbon\Carbon::parse($event->from)->diffForHumans() }})
                    </td>
                    <td>{{ $event->owner_group->name }}</td>
                </tr>
            @endforeach
        </table>

        <h5 class="mb-4">Předešlé akce</h5>

        <table class="table table-striped">
            <tr>
                <th>Název</th>
                <th>Termín</th>
                <th>Skupina</th>
            </tr>

            @foreach($previous_events as $event)
                <tr>
                    <td><a href="{{route('organize.dashboard', $event)}}">{{$event->name}}</a></td>
                    <td>{{ Carbon\Carbon::parse($event->from)->format('H:i d.m.') }}
                        ({{ Carbon\Carbon::parse($event->from)->diffForHumans() }})
                    </td>
                    <td>{{ $event->owner_group->name }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
