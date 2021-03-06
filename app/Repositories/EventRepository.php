<?php


namespace App\Repositories;


use App\Event;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class EventRepository
{
    /**
     * Return upcoming mother events for this user.
     *
     * @param $user
     *
     * @return Collection
     */
    public function getUserUpcomingMotherEvents(User $user)
    {
        $user_mother_groups = $user->groups()
                                   ->where('parent_group_id', null)
                                   ->get()
                                   ->pluck('id')
                                   ->toArray();

        return Event::where('to', '>', Carbon::now())
                    ->orderBy('from')
                    ->where('parent_event_id', null)
                    ->whereIn('owner_group_id', $user_mother_groups)
                    ->get();
    }

    /**
     * Return mother events from past for this user.
     *
     * @param $user
     *
     * @return Collection
     */
    public function getUserPreviousMotherEvents(User $user)
    {
        $user_mother_groups = $user->groups()
                                   ->where('parent_group_id', null)
                                   ->get()
                                   ->pluck('id')
                                   ->toArray();

        return Event::where('to', '<=', Carbon::now())
                    ->orderBy('from')
                    ->where('parent_event_id', null)
                    ->whereIn('owner_group_id', $user_mother_groups)
                    ->get();
    }
}
