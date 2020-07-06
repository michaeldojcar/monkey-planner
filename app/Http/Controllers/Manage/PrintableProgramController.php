<?php

namespace App\Http\Controllers\Manage;

use App\Group;
use App\Http\Controllers\Controller;
use App\Task;
use App\User;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use PHPUnit\Util\RegularExpressionTest;

class PrintableProgramController extends Controller
{
    public function index(Group $group)
    {
        return view('tabor_web.print.index')->withGroup($group);
    }

    public function master(Group $group)
    {
        $plan_controller = new EventPlanController();
        $days            = $plan_controller->getEventsArray($group->mainEvent);

        return view('tabor_web.print.master', [
            'group'         => $group,
            'non_scheduled' => $group->mainEvent->events()->where('is_scheduled', false)->get(),
            'days'          => $days,
        ]);
    }

    public function masterForUser(Group $group, User $user)
    {
        $plan_controller = new EventPlanController();
        $days            = $plan_controller->getEventsArray($group->mainEvent);

        return view('tabor_web.print.master', [
            'group'         => $group,
            'non_scheduled' => $group->mainEvent->events()->where('is_scheduled', false)->get(),
            'days'          => $days,
            'user'          => $user,
        ]);
    }

    public function dailyForUser(Group $group, $day, User $user)
    {
        $plan_controller = new EventPlanController();
        $events          = $plan_controller->getEventsFromDay($group->mainEvent, $day);

        $all_my_today_tasks = $this->getUserDayTasks($group, $day, $user);

        return view('tabor_web.print.daily', [
            'group'     => $group,
//            'days' => $days,
            'day'       => $day,
            'events'    => $events,
            'my_events' => $events->intersect($user->events),
            'user'      => $user,

            'all_my_tasks' => $all_my_today_tasks,
            'my_tasks'     => $all_my_today_tasks->where('type', 0),
            'my_roles'     => $all_my_today_tasks->where('type', 1),
            'my_items'     => $all_my_today_tasks->where('type', 2),
        ]);
    }

    public function dailyPoster(Group $group, $day)
    {
        $plan_controller = new EventPlanController();
        $events          = $plan_controller->getEventsFromDay($group->mainEvent, $day);

        return view('tabor_web.print.daily_poster', [
            'group'  => $group,
//            'days' => $days,
            'day'    => $day,
            'events' => $events,
        ]);
    }

    public function masterMass(Group $group)
    {
        return view('tabor_web.print.master_mass', [
            'group' => $group,
        ]);
    }

    public function dailyMass(Group $group, int $day)
    {
        return view('tabor_web.print.master_mass', [
            'group' => $group,
            'day'   => $day,
        ]);
    }

    /**
     * @param Group $group
     * @param int   $day
     * @param User  $user
     *
     * @return Task[]|Collection
     */
    public function getUserDayTasks(Group $group, int $day, User $user)
    {
        $plan_controller = new EventPlanController();

        $selected_date = $plan_controller->getDateFromRelativeDay($group->mainEvent, $day)->startOfDay();

        $today_tasks = $group->mainEvent->tasks->filter(function (Task $task) use ($selected_date)
        {

            if (empty($task->getSubEvent()))
            {
                return false;
            }

            if ($task->getSubEvent()->is_scheduled == 0)
            {
                return false;
            }

            return $task->getSubEvent()->from->startOfDay() == $selected_date;
        });


        $my_tasks = $user->tasks;

        return $my_tasks->intersect($today_tasks);
    }
}
