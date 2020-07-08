<div class="table-responsive material-shadow">
    <table class="table table-program"
           style="border-top: black 1px solid !important; margin-bottom: 0px !important;">
        <tr class="table-header">
            <td width="40"><span class="d-none d-sm-block">Den</span><span class="d-block d-sm-none">#</span></td>
            <td width="80">Datum</td>
            <td>Program</td>
        </tr>
        @foreach($days as $key => $day)
            <tr style="border-bottom: 2px black solid">
                <td>{{$key}}.</td>
                <td>@switch($main_event->countDateFromThisEventsDayNumber($key)->dayOfWeek)
                        @case(0)
                        <span>NE</span>
                        @break
                        @case(1)
                        <span>PO</span>
                        @break
                        @case(2)
                        <span>ÚT</span>
                        @break
                        @case(3)
                        <span>ST</span>
                        @break
                        @case(4)
                        <span>ČT</span>
                        @break
                        @case(5)
                        <span>PÁ</span>
                        @break
                        @case(6)
                        <span>SO</span>
                        @break
                    @endswitch
                    {{$main_event->countDateFromThisEventsDayNumber($key)->format('j.n.')}}</td>
                <td style="padding: 0">
                    <table class="table-inner">
                        @forelse($day as $sub_event)
                            {{--Hra--}}
                            <?php $sub_event_class = '' ?>

                            @if($sub_event->type == 3 ||$sub_event->type == 6)
                                <?php $sub_event_class = 'muted' ?>
                            @endif

                            @if($sub_event instanceof \App\Event)
                                <tr class="{{$sub_event_class}}">
                                    <td width="60">{{$sub_event->from->format('H:i')}}</td>
                                    <td width="120"
                                        style="text-align: right">
                                        {{ucfirst($sub_event->getTypeString())}}</td>
                                    <td width="400">
                                        <b>
                                            <a href="{{route('organize.events.show', [$group, $sub_event])}}">{{mb_strtoupper($sub_event->name)}}</a>
                                        </b>
                                    </td>
                                    <td>
                                        @component('tabor_web.components.program.event_authors_hybrid', ['event' => $sub_event])@endcomponent
                                    </td>
                                </tr>
                            @elseif($sub_event instanceof \App\EventTime)
                                <tr class="{{$sub_event_class}}">
                                    <td width="60">{{$sub_event->from->format('H:i')}}</td>
                                    <td width="120"
                                        style="text-align: right">
                                        {{ucfirst($sub_event->event->getTypeString())}}</td>
                                    <td width="400">
                                        <b>
                                            <a href="{{route('organize.events.show', [$group, $sub_event->event])}}">{{mb_strtoupper($sub_event->event->name)}}</a>
                                        </b>
                                    </td>
                                    <td>
                                        @component('tabor_web.components.program.event_authors_hybrid', ['event' => $sub_event->event])@endcomponent
                                    </td>
                                </tr>
                            @endif

                        @empty
                            <tr>
                                <td>-</td>
                            </tr>
                        @endforelse
                    </table>
                </td>
            </tr>
        @endforeach
    </table>
</div>
