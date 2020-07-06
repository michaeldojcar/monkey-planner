@extends('tabor_web.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Statistiky</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                {{--<button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#exampleModal">--}}
                {{--<i class="fas fa-plus" style="color: #00891a"></i> Nový blok programu--}}
                {{--</button>--}}
            </div>
        </div>
    </div>

    <h3>Vytížení teamu</h3>

    <table class="table">
        <tr>
            <th>Jméno</th>
            <th>Zátěž</th>
            <th>Zátěž příprava</th>
            <th>Zátěž na místě</th>
            <th>Úkoly</th>
            <th>Části programu</th>
            <th>Role v programu</th>
            <th>Sbírané věci</th>

        </tr>
        @foreach($members as $member)
            <tr>
                <td>{{$member->getWholeName()}}</td>

                <td style="width: 160px">{{$member->countOccupancy()}} %
                    <div class="progress">
                        <div class="progress-bar {{$member->countOccupancy()>100 ? 'bg-danger' : ''}}"
                             role="progressbar"
                             style="width: {{$member->countOccupancy()}}%"
                             aria-valuenow="100"
                             aria-valuemin="0"
                             aria-valuemax="100"></div>
                    </div>
                </td>
                <td style="width: 160px">{{$member->countBeforeOccupancy()}} %
                    <div class="progress">
                        <div class="progress-bar {{$member->countBeforeOccupancy()>100 ? 'bg-danger' : ''}}"
                             role="progressbar"
                             style="width: {{$member->countBeforeOccupancy()}}%"
                             aria-valuenow="100"
                             aria-valuemin="0"
                             aria-valuemax="100"></div>
                    </div>
                </td>
                <td style="width: 160px">{{$member->countEventOccupancy()}} %
                    <div class="progress">
                        <div class="progress-bar {{$member->countEventOccupancy()>100 ? 'bg-danger' : ''}}"
                             role="progressbar"
                             style="width: {{$member->countEventOccupancy()}}%"
                             aria-valuenow="100"
                             aria-valuemin="0"
                             aria-valuemax="100"></div>
                    </div>
                </td>
                <td>{{$member->tasks()->count()}}</td>
                <td>{{$member->events()->count()}}</td>
                <td>{{$member->roleTasks()->count()}}</td>
                <td>{{$member->itemTasks()->count()}}</td>

            </tr>
        @endforeach
    </table>

    <h3>Statistika přihlášení</h3>

    <table class="table">
        @foreach($members->sortByDesc('last_login_at') as $member)
            <tr>
                <td>{{$member->getWholeName()}} </td>
                <td>
                    @if($member->last_login_at)
                        {{$member->last_login_at->diffForHumans(Carbon\Carbon::now())}} ({{$member->last_login_at}})
                    @else
                        nikdy
                    @endif
                </td>
            </tr>

        @endforeach
    </table>
@endsection