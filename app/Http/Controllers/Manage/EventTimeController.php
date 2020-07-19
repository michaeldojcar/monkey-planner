<?php

namespace App\Http\Controllers\Manage;

use App\EventTime;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class EventTimeController extends Controller
{
    /**
     * Create event time.
     *
     * @param $event_id
     */
    public function store($event_id)
    {
//        $event_id;
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
