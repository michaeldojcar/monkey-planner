<?php

namespace App\Http\Controllers\Manage;

use App\Group;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Group $group)
    {
        $members = $group->users->sortBy('name');

        return view('tabor_web.members')->withGroup($group)->withMembers($members);
    }

    public function user(Group $group, User $user){

    }
}
