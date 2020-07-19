<?php

namespace App\Http\Controllers\Manage;

use App\Event;
use App\EventTime;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class EventTimeController extends Controller
{
    /**
     * Create event time.
     *
     * @param $event_id
     *
     * @return RedirectResponse
     */
    public function create($event_id)
    {
        $event = Event::findOrFail($event_id);

//        dd($event);

        $event_time           = new EventTime();
        $event_time->event_id = $event->id;
        $event_time->from     = $event->from;
        $event_time->to       = $event->to;
        $event_time->save();

        $event_id     = $event->parentEvent->id;
        $sub_event = $event->id;

        return redirect()->route('organize.events.show',
            [
                'event'     => $event_id,
                'sub_event' => $sub_event
            ]);
    }

    /**
     * Delete event time.
     *
     * @param $id
     *
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $event_time = EventTime::findOrFail($id);

        $event     = $event_time->event->parentEvent->id;
        $sub_event = $event_time->event_id;

        $event_time->delete();

        return redirect()->route('organize.events.show',
            [
                'event'     => $event,
                'sub_event' => $sub_event
            ]);
    }
}
