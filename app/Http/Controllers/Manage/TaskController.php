<?php

namespace App\Http\Controllers\Manage;

use App\Event;
use App\Group;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Session;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Group $group)
    {
        return view('tabor_web.tasks.index', [
            'group' => $group,
        ]);
    }

    public function store(Request $request, Group $group)
    {
        $task          = new Task();
        $task->name    = $request['name'];
        $task->content = $request['content'];
        $task->status  = 0; // Ready
        $task->save();

        if ($request['group_id'] != 0)
        {
            $task->groups()->attach($request['group_id']);
        }

        $task->events()->attach($group->main_event_id);

        return redirect()->route('organize.tasks', $group);
    }

    public function show(Group $group, Task $task)
    {
        Session::flash('url', \request()->server('HTTP_REFERER'));

        return view('tabor_web.tasks.show', [
            'task'  => $task,
            'group' => $group,

            'users'          => $group->users,
            'users_selected' => $task->users,

            'groups'          => $group->childGroups()->get()->push(Group::first()),
            'groups_selected' => $task->groups,

            'events'          => $group->mainEvent->events,
            'events_selected' => $task->events,
        ]);
    }

    /**
     * Assigns logged user to task.
     *
     * @param Task $task
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignMe(Task $task)
    {
        $task->users()->sync([Auth::id()]);

        return redirect()->back();
    }

    public function userDetach(Task $task, User $user)
    {
        $task->users()->detach($user->id);

        return redirect()->back();
    }

    public function cycleStatus(Task $task)
    {
        if ($task->status == 0)
        {
            $task->status = 1;
        }
        elseif ($task->status == 1)
        {
            $task->status = 2;
        }
        else
        {
            $task->status = 0;
        }

        $task->save();

        return $task->status;
    }

    public function edit(Group $group, Task $task)
    {
        Session::flash('url', \request()->server('HTTP_REFERER'));

        return view('tabor_web.tasks.edit', [
            'task'  => $task,
            'group' => $group,

            'users'          => $group->users,
            'users_selected' => $task->users,

            'groups'          => $group->childGroups()->get()->push(Group::first()),
            'groups_selected' => $task->groups,

            'events'          => $group->mainEvent->events,
            'events_selected' => $task->events,
        ]);
    }

    public function update(Group $group, Task $task, Request $request)
    {
        $task->name           = $request['name'];
        $task->content        = $request['content'];
        $task->required_count = $request['required_count'];
        $task->type           = $request['type'];

        if (empty($request['required_count']))
        {
            $task->required_count = 1;
        }

        $task->groups()->sync($request['groups']);
        $task->users()->sync($request['users']);
        $task->events()->sync($request['events']);

        $task->save();

        return Redirect::to(Session::get('url'));
    }

    /**
     * @param Group $group
     * @param Task  $task
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Group $group, Task $task)
    {
        $task->delete();

        return Redirect::to(Session::get('url'));
    }

    public function todo(Group $group)
    {
        \Auth::user()->last_login_at = Carbon::now();
        Auth::user()->save();

        // Percent assigned.
        if ($group->mainEvent->tasks()->count() > 0)
        {
            $percent_assigned = $group->mainEvent->assignedTasks()->count() / $group->mainEvent->tasks()->count() * 100;
            $percent_assigned = number_format($percent_assigned, 0);
        }
        else
        {
            $percent_assigned = 0;
        }


        return view('tabor_web.tasks.todo', [
            'group'                     => $group,
            'percent_assigned'          => $percent_assigned,
            'events_without_garant'     => $group->mainEvent->events()->doesntHave('garants')->get(),
            'events_with_missing_roles' => $group->mainEvent->events->filter(function (Event $ev)
            {
                if ($ev->roleTasks()->doesntHave('users')->count())
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }),
            'incomplete_events'         => $group->mainEvent->events->filter(function (Event $ev)
            {
                foreach ($ev->blocks as $block)
                {
                    return empty($block->content) ? true : false;
                }

                return false;
            }),
            'tasks_without_user'        => $group->mainEvent->basicTasks()->whereDoesntHave('users')->get(),
            'items_without_user'        => $group->mainEvent->itemTasks()->whereDoesntHave('users')->get(),
        ]);
    }

}
