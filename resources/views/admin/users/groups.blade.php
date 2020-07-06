@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Úprava uživatele: {{$user->getWholeName()}}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a class="btn btn-sm btn-outline-secondary" href="{{route('admin.users.edit', $user)}}">Storno</a>
            </div>
        </div>
    </div>

    <h5>Skupiny, do kterých uživatel patří</h5>
    <hr>

    <form method="POST" action="{{route('admin.users.groups.update', $user)}}">
        @csrf
        @method('PATCH')
        <table class="table table-striped">
            <th>Členství</th>
            <th>Správce</th>
            <th>Název skupiny</th>

            {{-- Výpis položek --}}
            @foreach($groups as $group)
                <tr>
                    <td width="50">
                        <input name="is_member[]"
                               value="{{$group->id}}"
                               type="checkbox" {{ $group->checkIfUserBelongsTo($user) ? 'checked' : ''}}>
                    </td>
                    <td width="50">
                        <input name="is_admin[]"
                               value="{{$group->id}}"
                               type="checkbox" {{ $group->getUserRole($user) == 1 ? 'checked' : ''}}>
                    </td>
                    <td>{{$group->name}}</td>
                </tr>

                {{-- Subgroups dané skupiny --}}
                @foreach($group->childGroups as $subgroup)
                    <tr>
                        <td width="50">
                            <input name="is_member[]"
                                   value="{{$subgroup->id}}"
                                   type="checkbox" {{ $subgroup->checkIfUserBelongsTo($user) ? 'checked' : ''}}>
                        </td>
                        <td width="50">
                            <input name="is_admin[]"
                                   value="{{$subgroup->id}}"
                                   type="checkbox" {{ $subgroup->getUserRole($user) == 1 ? 'checked' : ''}}>
                        </td>
                        <td style="padding-left: 5em;">{{$subgroup->name}}</td>
                    </tr>
                @endforeach
            @endforeach
        </table>

        <input class="btn btn-primary" type="submit" value="Uložit nastavení">
    </form>
@endsection
