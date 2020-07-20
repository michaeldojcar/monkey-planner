<?php

namespace App\Http\Controllers\Manage;

use App\Event;
use App\EventTime;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show event program view.
     *
     * @param $event_id
     *
     * @return Factory|View
     */
    public function program($event_id)
    {
        /* @var $event Event */
        $event = Event::with([
            'events',

            'events.users',
            'events.authors',
            'events.garants',

            'events.groups',
            'owner_group',
            'events.parentEvent'
        ])->findOrFail($event_id);

        $group = $event->owner_group;

        return view('tabor_web.program.program', [
            'main_event' => $event,
            'group'      => $group,

            'days'       => $this->getEventsArray($event), // Days with events
            'days_count' => $this->getAllDaysCount($event), // Only count

            'non_scheduled' => $event->events
                ->where('is_scheduled', false)
                ->sortBy('name')
        ]);
    }

    /**
     * Show program for specific relative day.
     *
     * @param $event_id
     * @param $day
     */
    public function programForDay($event_id, $day)
    {

    }

    /**
     * Show event calendar view.
     *
     * @param  Event  $event
     *
     * @return Factory|View Array of collection for every day.
     */
    public function calendar(Event $event)
    {
        $group = $event->owner_group;

        return view('tabor_web.program.calendar', [
            'main_event' => $event,
            'group'      => $group,

//            'days'       => $this->getEventsArray($event), // Days with events
            'days_count' => $this->getAllDaysCountWithArrangementDays($event), // Only count

            'non_scheduled' => $event->events()->where('is_scheduled', false)->orderBy('name')->get(),
        ]);
    }

    public function calendarApiIndex(Event $event)
    {
        $events_array = [];

        $events = $event->events;

        foreach ($events as $sub_event)
        {
            // Sub events with single time
            if ( ! $sub_event->has_multiple_times)
            {
                $events_array[] = [
                    'name' => $sub_event->name,
                    'id'   => $sub_event->id,

                    'type' => 'event',

                    'color' => $this->getColorForEventType($sub_event),
                    'start' => $sub_event->from->timestamp * 1000,
                    'end'   => $sub_event->to->timestamp * 1000,
                    'timed' => true,
                ];
            }
            // Sub events with multiple times
            else
            {
                foreach ($sub_event->event_times as $event_time)
                {
                    $events_array[] = [
                        'name' => $sub_event->name,
                        'id'   => $event_time->id,

                        'type' => 'event_time',

                        'color' => $this->getColorForEventType($sub_event),
                        'start' => $event_time->from->timestamp * 1000,
                        'end'   => $event_time->to->timestamp * 1000,
                        'timed' => true,
                    ];
                }
            }
        }

        $from = $event->from->subDays($event->arrangement_days);

        return [
            'event' => [
                'from' => $from->timestamp * 1000,
                'to'   => $event->to->timestamp * 1000,
                'days' => $this->getAllDaysCountWithArrangementDays($event),
            ],

            'events' => $events_array
        ];
    }

    public function storeCalendar(Request $request)
    {
        $events = $request->input('events');

        foreach ($events as $event_record)
        {
            if ($event_record['type'] == 'event')
            {
                $event = Event::find($event_record['id']);

                if ($event)
                {
                    $event->from = Carbon::parse($event_record['start'] / 1000)->addHours(2);
                    $event->to   = Carbon::parse($event_record['end'] / 1000)->addHours(2);
                    $event->save();
                }
            }

            if ($event_record['type'] == 'event_time')
            {
                $event_time = EventTime::find($event_record['id']);

                if ($event_time)
                {
                    $event_time->from = Carbon::parse($event_record['start'] / 1000)->addHours(2);
                    $event_time->to   = Carbon::parse($event_record['end'] / 1000)->addHours(2);
                    $event_time->save();
                }

            }
        }

        return 'Successfully updated.';
    }


    /**
     * Return carbon date from relative day.
     *
     * @param  Event  $main_event
     * @param  int  $day_num
     *
     * @return Carbon
     */
    public function getDateFromRelativeDay(Event $main_event, $day_num)
    {
        $main_date  = Carbon::parse($main_event->from);
        $result_day = $main_date->addDays($day_num - 1);

        return $result_day;
    }

    /**
     * Returns count of all days in event.
     *
     * @param  Event  $event
     *
     * @return int
     */
    public function getAllDaysCount(Event $event)
    {
        $start_date = Carbon::parse($event->from);
        $diff       = $start_date->diffInDays($event->to, false);

        return $diff;
    }

    public function getAllDaysCountWithArrangementDays(Event $event)
    {
        return $this->getAllDaysCount($event) + $event->arrangement_days;
    }


    public function getEventsFromDay(Event $main_event, $day_num)
    {
        $date = $this->getDateFromRelativeDay($main_event, $day_num);

        // Events
        $events = $main_event->events;

        $events_for_day = $events->where('from', '=', $date)
                                 ->where('is_scheduled', true)
                                 ->where('has_multiple_times', false);

        // Event times TODO: only from this main event
        $event_times = EventTime::whereDate('from', '=', $date)->get();

        return $events_for_day->merge($event_times)
                              ->sortBy('from');
    }

    public function getEventsArray(Event $main_event)
    {
        $max_day_count = $this->getAllDaysCount($main_event); // 13.

        $days = [];

        $first_day = 1 - $main_event->arrangement_days;

        for ($x = $first_day; $x <= $max_day_count; $x++)
        {
            $days[$x] = $this->getEventsFromDay($main_event, $x);
        }

        return $days;
    }


    private function findById($id)
    {
        return Event::findOrFail($id);
    }

    private function getColorForEventType(Event $event)
    {
        if ($event->type == 0)
        {
            return '#ff9100';
        }
        if ($event->type == 1)
        {
            return '#2196f3';
        }
        if ($event->type == 2)
        {
            return '#f4511e';
        }
        if ($event->type == 3)
        {
            return '#9025f9';
        }
        if ($event->type == 4)
        {
            return '#424242';
        }
        if ($event->type == 5)
        {
            return '#4a148c';
        }
        if ($event->type == 6)
        {
            return '#0097a7';
        }
    }
}
