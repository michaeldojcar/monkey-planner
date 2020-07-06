<?php


namespace App\Repositories;


use App\User;

class GroupRepository
{
    public function motherGroupsForUser(User $user)
    {
        return $user->groups()->where('parent_group_id', null);
    }
}
