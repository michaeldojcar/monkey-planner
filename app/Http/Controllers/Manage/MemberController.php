<?php

namespace App\Http\Controllers\Manage;

use App\Event;
use App\Group;
use App\Http\Controllers\Controller;
use App\User;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Event $event)
    {
        $members = $event->owner_group->users->sortBy('name');

        return view('tabor_web.members', [
            'group'   => $event->owner_group,
            'members' => $members,

            'main_event' => $event
        ]);
    }

    public function user(Group $group, User $user)
    {

    }
}
