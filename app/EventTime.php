<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventTime extends Model
{
    protected $dates = ['from', 'to'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
