{{-- Whole program printable view. --}}
<html lang="cs">
<head>
    <title>Program pro tisk</title>

    <link href="{{ asset('css/print.css') }}"
          rel="stylesheet">
</head>

<body style="">
    <div class="front-page d-flex flex-row align-content-around flex-wrap">
        <div id="content-wrapper"
             style="width: 100%">
            <div>
                <h1 style="font-size: 55px">{{$group->mainEvent->name}}</h1>
                <p>{{$group->mainEvent->from->format('j.n.')}} - {{$group->mainEvent->to->format('j.n. Y')}}</p>
            </div>

            <div class="text-left">
                <div style="font-size: 18px">Kompletní rozpis programu</div>
            </div>
        </div>

        @if(!empty($user))
            <h1>{{$user->getWholeName()}}</h1>
        @endif
    </div>

    <div style="text-align: center"
         class="mt-5 mb-5">
        <h1 style="margin-bottom: 5px">Program tábora</h1>
        <p>{{$group->mainEvent->from->format('j.n.')}} - {{$group->mainEvent->to->format('j.n. Y')}}</p>
    </div>


    <p>{{Auth::user()->name}} {{Auth::user()->surname}}</p>
    <p>Vytištěno: {{\Carbon\Carbon::now()->format('j.n. Y ')}} v {{\Carbon\Carbon::now()->format('H:i')}}</p>


    <h2>Obecné informace</h2>

    <div class="mb-5"
         style="font-family: Arial,serif !important;">
        {!! $group->mainEvent->content !!}
    </div>

    @foreach($non_scheduled as $sub_event)
        @component('tabor_web.print.components.scheduled_event_table', ['event' => $sub_event])@endcomponent
        <br>
    @endforeach

    <h2>Program</h2>

    @foreach($days as $key => $day)
        <div class="date-header">{{$key}}.
            DEN @switch($group->mainEvent->countDateFromThisEventsDayNumber($key)->dayOfWeek)
                @case(0)
                <span>(NE)</span>
                @break
                @case(1)
                <span>(PO)</span>
                @break
                @case(2)
                <span>(ÚT)</span>
                @break
                @case(3)
                <span>(ST)</span>
                @break
                @case(4)
                <span>(ČT)</span>
                @break
                @case(5)
                <span>(PÁ)</span>
                @break
                @case(6)
                <span>(SO)</span>
                @break
            @endswitch</div>

        {{-- Day events --}}
        @foreach($day as $sub_event)
            @component('tabor_web.print.components.scheduled_event_table', ['event' => $sub_event])@endcomponent
            <br>
        @endforeach
    @endforeach
</body>
</html>