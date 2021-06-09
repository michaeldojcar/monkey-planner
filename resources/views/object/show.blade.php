@extends('user.layout.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <div>
            <h3>{{$ob->name}}</h3>
        </div>
    </div>

    @foreach($ob->child_relations as $relation)
        <h4>{{$relation->name}}</h4>

        <div class="row">
            <div class="col-12">
                <table>
                    @foreach($relation->child_obs as $child_ob)
                        <tr>
                            <td><a href="{{route('objects.show',$child_ob)}}">{{$child_ob->name}}</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endforeach
@endsection
