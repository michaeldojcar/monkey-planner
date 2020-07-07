<?php

namespace App\Http\Controllers\Manage;

use App\Event;
use App\Group;
use App\Http\Controllers\Controller;
use App\Role;
use App\Task;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store($event_id, Request $request)
    {
        $main_event = Event::findOrFail($event_id);

        $event                  = new Event();
        $event->name            = $request['name'];
        $event->type            = $request['type'];
        $event->short           = $request['name'];
        $event->content         = $request['name'];
        $event->parent_event_id = $main_event->id;

        $start_date = $this->getDateFromRelativeDay($main_event, $request['day']);
        $start_date = $start_date->format('Y/m/d');
        $start_time = $request['time'];

        $event->from = Carbon::createFromFormat('Y/m/d H:i', $start_date.' '.$start_time);
        $event->to   = Carbon::parse($event->from." + 1 hour");
        $event->save();

        $bc = new BlockController();

        // Default info blocks.
        if ($event->type == 0) // Event
        {
            $bc->createBlock($event, "Obecné informace");
        }
        if ($event->type == 1) // Game
        {
            $bc->createBlock($event, "Motivace");
            $bc->createBlock($event, "Scénka");
            $bc->createBlock($event, "Stručný popis pravidel", 'Stručný popis pravidel - 3 věty max.');
            $bc->createBlock($event, "Pravidla hry");
            $bc->createBlock($event, "Hrají");

        }
        if ($event->type == 2) // Part of program
        {
            $bc->createBlock($event, "Obecné informace");
        }
        if ($event->type == 3) // Technical
        {
            $bc->createBlock($event, "Obecné informace");
        }
        if ($event->type == 4) // Event
        {
            $bc->createBlock($event, "Obecné informace");
        }

        return redirect()->back();
    }

    /**
     * @param $main_event_id
     * @param $sub_event_id
     *
     * @return Application|Factory|View
     */
    public function show($main_event_id, $sub_event_id)
    {
        $main_event = $this->findById($main_event_id);
        $sub_event  = $this->findById($sub_event_id);

        return view('tabor_web.events.show', [
            'group' => $main_event->owner_group,
            'event' => $sub_event,

            'main_event' => $main_event
        ]);
    }

    /**
     * @param $main_event_id
     * @param $event_id
     *
     * @return Application|Factory|View
     */
    public function edit($main_event_id, $event_id)
    {
        $main_event = $this->findById($main_event_id);
        $event      = $this->findById($event_id);

        return view('tabor_web.events.edit', [
            'group' => $main_event->owner_group,
            'event' => $event,

            'main_event' => $main_event,

            'days'                  => $this->getEventsArray($main_event), // Days with events
            'days_count'            => $this->getAllDaysCount($main_event), // Only count

            // Data for Magic suggest
            'author_users'          => $main_event->owner_group->users,
            'author_users_selected' => $event->authors()->get(),

            'author_groups'          => $main_event->owner_group->childGroups,
            'author_groups_selected' => $event->groups,

            'garant_users'          => $main_event->owner_group->users,
            'garant_users_selected' => $event->garants()->get(),
        ]);
    }

    /**
     * Update event.
     *
     * @param $event_id
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function update($event_id, Request $request)
    {
        $event = $this->findById($event_id);

        $event->name = $request['name'];

        if ($request->has('type'))
        {
            $event->type = $request['type'];
        }

        $event->place = $request['place'];

        // Change date and time (sub event only)
        if ( ! $event->isMainEvent())
        {
            if ($request['day'] != 'all')
            {
                // Compute Carbon date
                $start_date = $this->getDateFromRelativeDay($event->parentEvent, $request['day']);
                $start_date = $start_date->format('Y/m/d');

                // Time from
                $start_time  = $request['time_from'];
                $event->from = Carbon::createFromFormat('Y/m/d H:i', $start_date.' '.$start_time);

                // Time to
                $end_time  = $request['time_to'];
                $event->to = Carbon::createFromFormat('Y/m/d H:i', $start_date.' '.$end_time);
            }
            else
            {
                $event->is_scheduled = false;
            }
        }
        else
        {
            $event->from    = Carbon::parse($request['date_from']);
            $event->to      = Carbon::parse($request['date_to']);
            $event->content = $request['content'];
            $event->notice  = $request['notice'];
        }

        // Save model
        $event->save();

        // Sync related group
        $event->groups()->sync($request['author_groups']);

        // Sync related users
        $event->users()->withPivotValue('status', 5)->sync($request['author_users']);
        $event->users()->withPivotValue('status', 4)->sync($request['garant_users']);


        if ( ! $event->isMainEvent())
        {
            return redirect()->route('organize.events.show', [$event->parentEvent, $event]);
        }
        else
        {
            return redirect()->route('organize.program', $event);
        }
    }

    /**
     * @param  Group  $group
     * @param  Event  $event
     *
     * @return mixed
     * @throws Exception
     */
    public function delete(Group $group, Event $event)
    {
        $event->delete();

        return redirect()->route('organize.program', $group);
    }

    /**
     * Return carbon date from relative day.
     *
     * @param  Event  $parent_event
     * @param       $day_num
     *
     * @return Carbon
     */
    private function getDateFromRelativeDay(Event $parent_event, $day_num)
    {
        $main_date  = Carbon::parse($parent_event->from);
        $result_day = $main_date->addDays($day_num);

        return $result_day;
    }

    /**
     * Returns count of all days in event.
     *
     * @param  Event  $event
     *
     * @return int
     */
    private function getAllDaysCount(Event $event)
    {
        $start_date = Carbon::parse($event->from);
        $diff       = $start_date->diffInDays($event->to, false);

        return $diff;
    }


    public function storeRole(Event $event, Request $request)
    {
        $role                      = new Role();
        $role->name                = $request['name'];
        $role->required_user_count = $request['required_user_count'];
        $role->save();

        $role->events()->attach($event->id);

        return redirect()->back();
    }

    public function userTaskAssign(Task $task, User $user)
    {
        $task->users()->attach($user->id);

        return redirect()->back();
    }

    public function userTaskDetach(Task $task, User $user)
    {
        $task->users()->detach($user->id);

        return redirect()->back();
    }

    public function garantAssign(Event $event, User $user)
    {
        $event->users()->attach($user->id, ['status' => 4]);

        return redirect()->back();
    }

    public function garantDetach(Event $event, User $user)
    {
        $event->garants()->detach($user->id);

        return redirect()->back();
    }

    public function authorAssign(Event $event, User $user)
    {
        $event->users()->attach($user->id, ['status' => 5]);

        return redirect()->back();
    }

    public function authorDetach(Event $event, User $user)
    {
        $event->authors()->detach($user->id);

        return redirect()->back();
    }

    public function taskCreateAndAssign(Event $event, Request $request)
    {
        $task = new Task();

        // Basic task
        if ($request['type'] == 0)
        {
            $task->name    = $request['name'];
            $task->type    = $request['type'];
            $task->content = $request['content'];
        }
        // Role task
        elseif ($request['type'] == 1)
        {
            $task->name           = $request['name'];
            $task->type           = $request['type'];
            $task->content        = '';
            $task->required_count = $request['required_count'];
        }
        // Item task
        elseif ($request['type'] == 2)
        {
            $task->name           = $request['name'];
            $task->type           = $request['type'];
            $task->item_id        = 0;
            $task->required_count = $request['required_count'];
        }


        $task->content = $request['content'];
        $task->status  = 0; // Ready
        $task->save();

        if ($request['group_id'] != 0)
        {
            $task->groups()->attach($request['group_id']);
        }

        $task->events()->attach($event->parent_event_id);
        $task->events()->attach($event->id);

        return redirect()->back();
    }


    private function findById($id)
    {
        return Event::findOrFail($id);
    }

    public function getEventsArray(Event $main_event)
    {
        $max_day_count = $this->getAllDaysCount($main_event);

        $days = [];

        for ($x = 0; $x <= $max_day_count; $x++)
        {
            $days[$x] = $this->getEventsFromDay($main_event, $x);
        }

        return $days;
    }

    public function getEventsFromDay(Event $main_event, $day_num)
    {
        $date = $this->getDateFromRelativeDay($main_event, $day_num);

        $events = $main_event->events();

        return $events->whereDate('from', '=', $date)->where('is_scheduled', true)->orderBy('from')->get();
    }
}
