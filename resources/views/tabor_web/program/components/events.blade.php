@foreach($days as $key => $day)
    <div class="date-header">{{$key}}.
        DEN @switch($main_event->countDateFromThisEventsDayNumber($key)->dayOfWeek)
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
        @component('tabor_web.program.components.event_page', ['event' => $sub_event])@endcomponent
        <br>
    @endforeach
@endforeach
