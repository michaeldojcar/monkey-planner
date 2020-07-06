@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 style="margin-bottom: 0">{{$event->name}}</h1>
        <i style="display: block; margin-bottom: 2em">{{ Carbon\Carbon::parse($event->from)->format('d.m. H:i') }}
            ({{ Carbon\Carbon::parse($event->from)->diffForHumans() }}) v rámci skupiny <a
                    href="{{route('group',['id'=>$event->groups()->first()->id])}}">{{ $event->groups()->first()->name }}</a></i>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Seznam účastníků</div>

                    <div class="card-body">
                        @if($event->users->count() == 0)
                            <i>žádní účastníci</i>
                        @else
                            <table class="table">
                                @foreach($event->users as $user)
                                    <tr>
                                        <td>{{$user->getWholeName()}}</td>
                                        <td style="text-align: right">
                                            @if($event->getUserParticipationStatus($user) == 4)
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a class="btn btn-outline-primary" href="">
                                                        <i class="fas fa-user-edit"></i> Garant události
                                                    </a>
                                                </div>
                                            @else
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a class="btn
                                                        @if($event->getUserParticipationStatus($user) == 1)
                                                            btn-success
                                                        @else
                                                            btn-outline-secondary
                                                        @endif
                                                            "
                                                       href="{{route('event.participate.admin',['event_id'=>$event->id, 'user_id'=> $user->id,'status'=>1])}}">
                                                        <i class="fas fa-check"></i></a>
                                                    <a class="btn
                                                        @if($event->getUserParticipationStatus($user) == 2)
                                                            btn-warning
                                                        @else
                                                            btn-outline-secondary
                                                        @endif
                                                            "
                                                       href="{{route('event.participate.admin',['event_id'=>$event->id, 'user_id'=> $user->id,'status'=>2])}}">
                                                        <i class="fas fa-question"></i></a>
                                                    <a class="btn
                                                        @if($event->getUserParticipationStatus($user) == 3)
                                                            btn-danger
                                                        @else
                                                            btn-outline-secondary
                                                        @endif
                                                            "
                                                       href="{{route('event.participate.admin',['event_id'=>$event->id, 'user_id'=> $user->id,'status'=>3])}}">
                                                        <i class="fas fa-times"></i></a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                @if($event->getUserParticipationStatus(Auth::user()) == 4)
                    <div class="card">
                        <div class="card-header" style="background-color: #fff1b4">Možnosti události</div>
                        <div class="card-body">
                            <a class="btn btn-outline-primary" style="margin-bottom: 1em;" href="{{route('admin.event.add.members',['event_id'=>$event->id, 'status'=>0])}}">Pozvat
                                všechny členy skupiny {{$event->groups()->first()->name}}</a><br>
                            <a class="btn btn-outline-primary" href="{{route('admin.event.add.members',['event_id'=>$event->id, 'status'=>1])}}">Přidat všechny členy jako zúčastněné</a>
                            <a class="btn btn-outline-primary" href="{{route('admin.event.sms',['id'=>$event->id])}}">Odeslat SMS</a>

                            <hr>

                            <form action="{{route('admin.event.sms.custom')}}" method="post">
                                @csrf
                                <textarea name="msg" style="width: 100%; height:200px;" placeholder="Obsah SMS zprávy."></textarea>
                                <input type="hidden" name="event_id" value="{{$event->id}}">
                                <input type="submit" onclick="return confirm('SMS zpráva bude odeslána všem pozvaným. Pokračovat?')">
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection