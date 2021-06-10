@extends('user.layout.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
        <div>
            <h3>
                <span class="badge badge-primary" title="{{$ob->type->description}}">{{$ob->type->name}}</span> {{$ob->name}}
            </h3>

        </div>
    </div>

    <table class="table">
        @foreach($ob->type->attributes as $attribute)
            <tr>
                <td>{{$attribute->name}}</td>
                <td>
                    {{$attribute->getValueForOb($ob)}}
                </td>
            </tr>
        @endforeach
    </table>
@endsection
