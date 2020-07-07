<?php

namespace App\Http\Controllers\Manage;

use App\Event;
use App\Http\Controllers\Controller;

class MemberStatsController extends Controller
{
    public function workStats(Event $event)
    {
        return view('tabor_web.work_stats', [
            'main_event' => $event,

            'group'   => $event->owner_group,
            'members' => $event->owner_group
                ->users()
                ->with('tasks')
                ->get()
                ->sortByDesc(function ($user)
                {
                    return $user->countOccupancy();
                }),
        ]);
    }
}
