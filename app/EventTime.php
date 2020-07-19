<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EventTime extends Model
{
    protected $dates = ['from', 'to'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Counts the relative day count according to related event.
     *
     * @return int
     */
    public function getDayNumber()
    {
        $date      = Carbon::parse($this->event->parentEvent->from)->startOfDay();
        $main_date = Carbon::parse($this->from);

        $diff = $date->diffInDays($main_date, false);

        return $diff;
    }
}
