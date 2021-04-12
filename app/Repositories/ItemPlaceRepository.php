<?php


namespace App\Repositories;


use App\User;
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
            ->flatten();
    }


    public function getMainItemPlacesForGroup(\Illuminate\Database\Eloquent\Model $group)
    {
        return $group->item_places()->where('parent_id', null)->get();
    }
}
