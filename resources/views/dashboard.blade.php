@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 style="margin-bottom: 20px">Moje nástěnka</h1>

        <div class="card">
            <div class="card-header">Moje společenství</div>

            <div class="card-body">
                @if($groups->count() == 0)
                    <i>Zatím nemáte přiřazenou žádnou skupinu. Pokud do nějaké patříte, kontaktujte osobu, která
                        má danou skupinu na starost.</i>
                @else
                    <div class="row">
                        @foreach($groups as $group)
                            <div class="col-md-2">
                                @if(isset($group->mainEvent))
                                    <a href="{{route('organize.dashboard',['id' => $group->id])}}">
                                        <div class="card group-card">
                                            <div class="card-body">
                                                {{$group->name}}
                                            </div>
                                        </div>
                                    </a>
                                @else
                                    <a href="{{route('group',['id' => $group->id])}}">
                                        <div class="card group-card">
                                            <div class="card-body">
                                                {{$group->name}}
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-7">
                <div class="card">
                    <div class="card-header">Moje služby</div>

                    <div class="card-body">
                        <i>Nemáte zapsané žádné služby.</i>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="card">
                    <div class="card-header">Kalendář</div>

                    <div class="card-body">
                        @if($upcoming->count() == 0)
                            <i>Nemáte naplánované žádné události. :-)</i>
                        @else
                            <table class="table">
                                @foreach($upcoming as $event)
                                    <tr>
                                        <td style="padding-bottom: 10px">
                                            <a href="{{route('event',['id'=>$event->id])}}">{{$event->name}}</a><br>
                                            <i>{{ Carbon\Carbon::parse($event->from)->format('H:i d.m.') }}
                                                ({{ Carbon\Carbon::parse($event->from)->diffForHumans() }})</i>
                                        </td>
                                        <td style="text-align: right">
                                            @include('components.participationSelectPrivate')
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection