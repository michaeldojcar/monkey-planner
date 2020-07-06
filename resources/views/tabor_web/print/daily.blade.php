{{-- Printable program for daily plan. --}}
<html lang="cs">

<head>
    <title>Rozpis na {{$day}}. den - {{$user->name}} {{$user->surname}}</title>

    <link href="{{ asset('css/print.css') }}"
          rel="stylesheet">

    <meta charset="utf-8">
</head>
<body>
    <div class="front-page d-flex flex-row align-content-around flex-wrap">
        <div id="content-wrapper"
             style="width: 100%">
            <div>
                <h1 style="font-size: 55px">Denní plán - {{$day}}. DEN</h1>
                <p>{{$group->mainEvent->from->format('j.n.')}} - {{$group->mainEvent->to->format('j.n. Y')}}</p>
            </div>

            <div class="text-left">
                <div style="font-size: 18px">Rozpis programu a úkolů na
                    den {{ $group->mainEvent->countDateFromThisEventsDayNumber($day)->format('j.n. Y') }}</div>
            </div>
        </div>
    </div>

    <div style="text-align: center">
        <h1 style="margin-bottom: 5px">Denní plán</h1>
        <p>{{$user->name}} {{$user->surname}} - <b>{{$day}}. DEN </b></p>
    </div>

    <p style="font-size: 11px">Vytištěno: {{\Carbon\Carbon::now()->format('j.n. Y ')}}
        v {{\Carbon\Carbon::now()->format('H:i')}}</p>

    <h2>Předpověď počasí</h2>

    <a href="http://www.slunecno.cz/mista/lostice-511"><img src="http://www.slunecno.cz/pocasi-na-web.php?n&amp;obr=7&amp;m=511&amp;d=8&amp;p1=FFFFFF&amp;t1=000000"
                                                            alt="Počasí Loštice - Slunečno.cz"
                                                            style="border: 0px; width: 80%"/></a>

    <h2>Harmonogram</h2>


    <table>
        <tr style="background-color: lightgrey">
            <td colspan="2">{{$day}}. den</td>
        </tr>

        <tr style="font-size: 11px; background-color: #e4e4e4">
            <td>Časový odhad</td>
            <td>Program</td>
        </tr>

        @foreach($events as $sub_event)
            <tr style="font-size: 20px;">
                <td style=" width: 80px">
                    {{ucfirst($sub_event->from->format("H:i"))}}
                </td>
                <td>
                    @if($sub_event->garants->contains('id', $user->id))
                        <b><u><span style="text-transform: uppercase; font-size: 20px">{{$sub_event->name}}</span>
                                (garantuji)</u></b>
                    @else
                        {{ucfirst($sub_event->name)}}
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

    @if($all_my_tasks->count() > 0 || $my_events->count() > 0)
        <h2>Moje dnešní věci</h2>
    @endif

    @if($my_events->count() > 0)
        <table style="margin-bottom: 13px">
            <tr>
                <td style="background-color: #e2e2e2; font-weight: bold; font-size: 14px;">Moje aktivity (jsem
                    garant/autor)
                </td>
            </tr>
            <tr>
                <td>
                    @foreach($my_events as $sub_event)
                        {{$sub_event->name}}{{$loop->last ? '' : ', '}}
                    @endforeach
                </td>
            </tr>
        </table>
    @endif

    @if($my_tasks->count() > 0)
        <table style="margin-bottom: 13px">
            <tr>
                <td style="background-color: #e2e2e2; font-weight: bold; font-size: 14px;">Úkoly</td>
            </tr>
            @foreach($my_tasks as $task)
                <tr>
                    <td style="color: black;">
                        {{$task->name}}
                        - @include('tabor_web.components.event.role_garants')
                    </td>
                </tr>
            @endforeach
        </table>
    @endif

    @if($my_roles->count() > 0)
        <h3>Role v programu</h3>
        @foreach($my_roles as $task)
            <table style="margin-bottom: 13px">
                <tr>
                    <td style="background-color: #e0e0e0">
                        <i>{{$task->getSubEvent()->name}}</i> → <b>{{$task->name}}</b>
                        - @include('tabor_web.components.event.role_garants')
                        <div style="float: right"></div>
                    </td>
                </tr>
                @if(isset($task->content))
                    <tr>

                        <td>
                            {!! $task->content !!}
                        </td>
                    </tr>
                @endif
            </table>
        @endforeach
    @endif

    @if($my_items->count() > 0)

        <table style="margin-bottom: 9px">
            <tr>
                <td style="background-color: #e2e2e2; font-weight: bold; font-size: 14px;">Věci a rekvizity</td>
            </tr>
            @foreach($my_items as $task)
                <tr>
                    <td style="color: black;">
                        {{$task->name}}
                        - @include('tabor_web.components.event.role_garants')
                    </td>
                </tr>
            @endforeach
        </table>

    @endif


    <h2>Program dne</h2>
    {{-- Day events --}}
    @foreach($events as $sub_event)
        @component('tabor_web.print.components.scheduled_event_table', [
            'event'=>$sub_event,
            'group' => $group])@endcomponent
        <br>
    @endforeach

</body>
</html>