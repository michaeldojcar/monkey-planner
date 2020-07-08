@extends('tabor_web.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h3>{{$main_event->name}} - členové týmu</h3>
    </div>

    <div class="table-responsive material-shadow">
        <table class="table table-bordered mb-0">
            <tr class="table-header">
                <th>Jméno</th>
                <th>Pod-týmy</th>
                <th>Email</th>
                <th>Mobil</th>
            </tr>
            @foreach($members as $user)
                <tr>
                    <td>{{$user->getWholeName()}}</td>
                    <td>
                        @foreach($user->groups()->where('parent_group_id', $group->id)->get() as $sub_group)
                            <div style="text-transform: uppercase; font-weight: bold; color: purple;">{{$sub_group->name}}</div>
                        @endforeach
                    </td>
                    <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                    <td>{{$user->phone}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
