@extends('tabor_web.layout')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Materiály pro tisk</h1>
        <div class="btn-toolbar mb-2 mb-md-0">

        </div>
    </div>

    <h2>Denní plán</h2>

    @for($i = 0; $i <= $group->mainEvent->getAllDaysCount(); $i++)
        <a class="btn btn-warning"
           href="{{ route("organize.program.print.daily.mass", [$group, $i]) }}">{{$i}}. den</a>
    @endfor



    <h2>Plakát s harmonogramem</h2>

    @for($i = 0; $i <= $group->mainEvent->getAllDaysCount(); $i++)
        <a class="btn btn-primary"
           href="{{ route("organize.program.print.daily.poster", [$group, $i]) }}">{{$i}}. den</a>
    @endfor

{{--    @foreach($group->users)--}}
{{--        <a class="btn btn-primary"></a>--}}
{{--    @endforeach--}}
@endsection