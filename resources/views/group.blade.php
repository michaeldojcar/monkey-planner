@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col"><h1 style="margin-bottom: 0">{{$group->name}}</h1>
                <i style="display: block; margin-bottom: 2em">{{ $group->sayMembersCount() }}@if(isset($group->parentGroup)), patří pod skupinu <a
                                href="{{route('group',['id'=>$group->parentGroup->id])}}">{{$group->parentGroup->name}}</a>@endif
                </i>
            </div>
            <div class="col" style="text-align: right;">
                @if($group->checkIfAuthAdmin())
                    <a class="btn btn-yellow">+ Založit událost</a>
                @endif
                <a class="btn btn-yellow" href="/">Zpět na nástěnku</a>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Nadcházející události</div>

                    <div class="card-body">
                        @if($upcoming->count() == 0)
                            <i>žádná událost není v plánu</i>
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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Informace o skupině</div>
                    <div class="card-body">
                        Členové:<br>
                        @foreach($group->users as $user)
                            {{ $user->getWholeName() }}{{ $loop->last ? '' : ', ' }}<br>
                        @endforeach
                    </div>
                </div>

                @if($group->childGroups->count() > 0)
                    <div class="card">
                        <div class="card-header">Podskupiny</div>

                        <div class="card-body">
                            <div class="row">
                                @foreach($subgroups as $subgroup)
                                    @if($subgroup->checkIfAuthBelongsTo())
                                        <div class="col-6">
                                            <a href="{{route('group',['id' => $subgroup->id])}}">
                                                <div class="card group-card">
                                                    <div class="card-body">
                                                        {{$subgroup->name}}
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                                @foreach($subgroups as $subgroup)
                                    @if(! $subgroup->checkIfAuthBelongsTo())
                                        <div class="col-6">
                                            <div class="card group-card-disabled">
                                                <div class="card-body">
                                                    {{$subgroup->name}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                @if($group->checkIfAuthAdmin())
                    <div class="card">
                        <div class="card-header card-header-yellow">Přidání členů</div>
                        <div class="card-body">
                            @foreach($group->getUsersToAdd() as $user)
                                <a href="{{route('group.user.add',['user_id'=>$user->id, 'group_id'=>$group->id])}}">{{$user->getWholeName()}}</a>
                                <br>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection