<?php

namespace App\Http\Controllers\User;

use App\Group;
use App\Http\Controllers\Controller;
use App\Repositories\GroupRepository;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(GroupRepository $group_repository)
    {
        return view('user.groups.index', [
            'groups' => $group_repository->motherGroupsForUser(Auth::user())->get()
        ]);
    }

    public function show($id)
    {
        $group = Group::findOrFail($id);

        return view('user.groups.show', [
            'group' => $group
        ]);
    }
}
