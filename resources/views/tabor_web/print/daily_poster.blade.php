{{-- Printable program for daily plan. --}}
<html lang="cs">

<head>
    <title>Rozpis na {{$day}}. den</title>

    <link href="{{ asset('css/print.css') }}"
          rel="stylesheet">

    <meta charset="utf-8">
</head>
<body>
    <div style="text-align: center">
        <h1 style="margin-bottom: 5px">Denní plán - {{$day}}. DEN </h1>
    </div>

    <p style="font-size: 11px">Vytištěno: {{\Carbon\Carbon::now()->format('j.n. Y ')}}
        v {{\Carbon\Carbon::now()->format('H:i')}}</p>

    <h2>Předpověď počasí</h2>

    <a href="http://www.slunecno.cz/mista/lostice-511"><img src="http://www.slunecno.cz/pocasi-na-web.php?n&amp;obr=7&amp;m=511&amp;d=8&amp;p1=FFFFFF&amp;t1=000000"
                                                            alt="Počasí Loštice - Slunečno.cz"
                                                            style="border: 0px; width: 80%"/></a>

    <h2>Harmonogram dneška (podle večerní porady)</h2>


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
                    {{ ucfirst($sub_event->from->format("H:i")) }}
                </td>
                <td>
                    {{ ucfirst($sub_event->name) }}
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>