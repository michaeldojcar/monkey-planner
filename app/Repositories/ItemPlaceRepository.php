<?php


namespace App\Repositories;


use App\Group;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ItemPlaceRepository
{
    /**
     * @param User $user
     *
     * @return Collection
     */
    public function getMainItemPlacesForUser(User $user): Collection
    {
        $user = $user->load('groups.item_places');

        return $user->groups
            ->pluck('item_places')
            ->flatten()
            ->where('parent_id', null);
    }


    public function getMainItemPlacesForGroup(Group $group): \Illuminate\Database\Eloquent\Collection
    {
        return $group->item_places()->where('parent_id', null)->get();
    }
}
