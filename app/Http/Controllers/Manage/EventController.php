<?php

namespace App\Http\Controllers\Manage;

use App\Event;
use App\Group;
use App\Role;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
            $task->item_id = 0;
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
}
