<?php

namespace App\Http\Controllers\Manage;

use App\Backend\Lang;
use App\Event;
use App\Group;
use App\User;
use Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Collection;


class DashController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Úvodní nástěnka táborového webu.
     * Statistiky, progress.
     *
     * @param $group_id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard($group_id)
    {
        Auth::user()->last_login_at = Carbon::now();
        Auth::user()->save();

        // Eager data loading
        $group       = Group::with(['mainEvent', 'mainEvent.tasks', 'mainEvent.events.tasks', 'mainEvent.events.parentEvent'])->findOrFail($group_id);
        $logged_user = User::with(['events', 'tasks', 'events.tasks'])->findOrFail(Auth::id());

        $main_event = $group->mainEvent;

        $event_tasks = $main_event->tasks;

        return view('tabor_web.dashboard', [
            'main_event' => $main_event,
            'group'      => $group,

            'tasks' => $event_tasks,

            'lang' => new Lang(),

            'week_to_event' => Carbon::now()->diffInDays($main_event->from),

            'my_roles'  => $main_event->roleTasks->intersect($logged_user->roleTasks),
            'my_items'  => $main_event->itemTasks->intersect($logged_user->itemTasks),
            'my_events' => $main_event->events->intersect($logged_user->events)->sortBy('from'),
            'my_tasks'  => $main_event->basicTasks->intersect($logged_user->basicTasks),
        ]);
    }

    public function subGroupDashboard(Group $group, Group $subgroup)
    {
        Auth::user()->last_login_at = Carbon::now();
        Auth::user()->save();

        return view('tabor_web.subgroup_dashboard', [
            'group'        => $group,
            'subgroup'     => $subgroup,
            'group_tasks'  => $subgroup->tasks,
            'group_events' => $subgroup->events,
        ]);
    }
}
