<?php

namespace App\Http\Controllers\Admin;

use App\Group;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class UserGroupController
 *
 * Správa skupin daného uživatele.
 *
 * @package App\Http\Controllers\Admin
 */
class UserGroupController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.groups', [
            'user'   => $user,
            'groups' => Group::whereNull('parent_group_id')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User                     $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        // Assigns selected groups to member, deletes any not selected.
        $user->groups()->sync($request['is_member']);

        // Newly added group admin.
        foreach ($user->groups as $group)
        {
            // If user is at least in on group set as admin.
            if (isset($request['is_admin']))
            {
                // Role for current iteration group.
                $role = in_array($group->id, $request['is_admin']);
            }
            // There is no group with admin access.
            else
            {
                $role = false;
            }

            $user->groups()->updateExistingPivot($group, ['role' => $role]);
        }

        // Returns back to user edit.
        return redirect()->route('admin.users.edit', $user);
    }
}
