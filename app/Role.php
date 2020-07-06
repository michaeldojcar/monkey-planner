<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Role
 *
 * @property int                                                        $id
 * @property string                                                     $name
 * @property string                                                     $required_user_count
 * @property \Illuminate\Support\Carbon|null                            $created_at
 * @property \Illuminate\Support\Carbon|null                            $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Event[] $events
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[]  $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereRequiredUserCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role query()
 */
class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function getUnassignedUserPlacesCount()
    {
        return $this->required_user_count - $this->users()->count();
    }

    public function isAuthAssigned()
    {
        if ($this->users->contains(Auth::id()))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}