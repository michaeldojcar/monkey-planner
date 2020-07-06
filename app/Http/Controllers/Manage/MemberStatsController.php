<?php

namespace App\Http\Controllers\Manage;

use App\Group;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberStatsController extends Controller
{
    public function workStats(Group $group)
    {
        return view('tabor_web.work_stats', [
            'group'   => $group,
            'members' => $group->users()->with('tasks')->get()->sortByDesc(function ($user)
            {
                return $user->countOccupancy();
            }),
        ]);
    }
}
