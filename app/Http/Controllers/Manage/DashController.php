<?php

namespace App\Http\Controllers\Manage;

use App\Backend\Lang;
use App\Event;
use App\Group;
use App\Http\Controllers\Controller;
use App\Task;
use App\User;
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
        /* @var $main_event Event */
        $main_event = Event::with('events.tasks')->findOrFail($event_id);

        // Eager data loading
        $group = Group::with([
            'mainEvent',
            'mainEvent.tasks',
            'mainEvent.events.tasks',
            'mainEvent.events.parentEvent'
        ])->findOrFail($main_event->owner_group_id);

        $logged_user = User::with([
            'events',
            'tasks',
            'events.tasks'
        ])->findOrFail(Auth::id());

        $event_tasks = $main_event->getSubEventTasks();

        return view('tabor_web.dashboard', [
            'main_event' => $main_event,
            'group'      => $group,

            'tasks' => $event_tasks,

            'lang' => new Lang(),

            'week_to_event' => Carbon::now()->diffInDays($main_event->from),

            // My tasks in sub-events
            'my_tasks'      => $event_tasks->where('type', Task::TYPE_BASIC)->intersect($logged_user->basicTasks),
            'my_roles'      => $event_tasks->where('type', Task::TYPE_ROLE)->intersect($logged_user->roleTasks),
            'my_items'      => $event_tasks->where('type', Task::TYPE_ITEM)->intersect($logged_user->itemTasks),

            'my_events' => $main_event->events->intersect($logged_user->events)->sortBy('from'),
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
