<?php

namespace App\Http\Controllers\Manage;

use App\Event;
use App\Group;
use App\Http\Controllers\Controller;
use App\Task;
use App\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Event $event)
    {
        return view('tabor_web.tasks.index', [
            'main_event' => $event,
            'group'      => $event->owner_group,
        ]);
    }

    public function store(Request $request, Group $group)
    {
        $task          = new Task();
        $task->name    = $request['name'];
        $task->content = $request['content'];
        $task->status  = 0; // Ready
        $task->save();


        $task->events()->attach($group->main_event_id);


        if ($request['group_id'] != 0)
        {
            $task->groups()->attach($request['group_id']);
        }

        return redirect()->route('organize.tasks', $group);
    }

    public function show(Event $event, Task $task)
    {
        Session::flash('url', \request()->server('HTTP_REFERER'));

        return view('tabor_web.tasks.show', [
            'main_event' => $event,

            'task'  => $task,
            'group' => $event->owner_group,

            'users'          => $event->owner_group->users,
            'users_selected' => $task->users,

            'groups'          => $event->owner_group->childGroups()->get()->push(Group::first()),
            'groups_selected' => $task->groups,

            'events'          => $event->events,
            'events_selected' => $task->events,
        ]);
    }

    /**
     * Assigns logged user to task.
     *
     * @param  Task  $task
     *
     * @return RedirectResponse
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

    public function edit(Event $event, Task $task)
    {
        Session::flash('url_back', \request()->server('HTTP_REFERER'));

        return view('tabor_web.tasks.edit', [
            'main_event' => $event,

            'task'  => $task,
            'group' => $event->owner_group,

            'users'          => $event->owner_group->users,
            'users_selected' => $task->users,

            'groups'          => $event->owner_group->childGroups()->get()->push(Group::first()),
            'groups_selected' => $task->groups,

            'events'          => $event->events,
            'events_selected' => $task->events,
        ]);
    }

    public function update(Event $event, Task $task, Request $request)
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

        return redirect(Session::get('url_back'));
    }

    /**
     * @param  Task  $task
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function delete(Task $task)
    {
        $task->delete();

        return Redirect::to(Session::get('url'));
    }

    /**
     * @param  Event  $event
     *
     * @return Application|Factory|View
     */
    public function todo(Event $event)
    {
        // Percent assigned.
        if ($event->tasks()->count() > 0)
        {
            $percent_assigned = $event->assignedTasks()->count() / $event->tasks()->count() * 100;
            $percent_assigned = number_format($percent_assigned, 0);
        }
        else
        {
            $percent_assigned = 0;
        }


        return view('tabor_web.tasks.todo', [
            'group'                     => $event->owner_group,
            'main_event'                => $event,
            'percent_assigned'          => $percent_assigned,
            'events_without_garant'     => $event->events()->doesntHave('garants')->get(),
            'events_with_missing_roles' => $event->events->filter(function (Event $ev)
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
            'incomplete_events'         => $event->events->filter(function (Event $ev)
            {
                foreach ($ev->blocks as $block)
                {
                    return empty($block->content) ? true : false;
                }

                return false;
            }),
            'tasks_without_user'        => $event->basicTasks()->whereDoesntHave('users')->get(),
            'items_without_user'        => $event->itemTasks()->whereDoesntHave('users')->get(),
        ]);
    }

}
