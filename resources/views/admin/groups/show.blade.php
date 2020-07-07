@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <a href="{{route('admin.groups.edit', $group)}}"
           class="btn btn-secondary float-right">Upravit</a>

        <h3>{{$group->name}}</h3>
        <p>Přípravný tým</p>

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">Členové</div>
                    <div class="card-body">
                        @forelse($group->users as $user)
                            <tr>
                                <td>{{$user->getWholeName()}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td>Skupina nemá členy.</td>
                            </tr>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
