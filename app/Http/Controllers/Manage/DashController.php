<?php

namespace App\Http\Controllers\Manage;

use App\Backend\Lang;
use App\Event;
use App\Group;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class DashController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Dashboard of selected mother event.
     *
     * @param $event_id
     *
     * @return Factory|View
     */
    public function dashboard($event_id)
    {
        $main_event = Event::findOrFail($event_id);

        // Eager data loading
        $group       = Group::with(['mainEvent', 'mainEvent.tasks', 'mainEvent.events.tasks', 'mainEvent.events.parentEvent'])->findOrFail($main_event->owner_group_id);
        $logged_user = User::with(['events', 'tasks', 'events.tasks'])->findOrFail(Auth::id());

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

    /**
     * Dashboard of selected sub-event.
     *
     * @param  Group  $group
     * @param  Group  $subgroup
     *
     * @return Application|Factory|View
     */
    public function subGroupDashboard(Group $group, Group $subgroup)
    {
        return view('tabor_web.subgroup_dashboard', [
            'group'        => $group,
            'subgroup'     => $subgroup,
            'group_tasks'  => $subgroup->tasks,
            'group_events' => $subgroup->events,
        ]);
    }
}
