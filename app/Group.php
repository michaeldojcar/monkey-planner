<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Group
 *
 * @property int                                                        $id
 * @property string                                                     $name
 * @property string|null                                                $parent_group_id
 * @property \Illuminate\Support\Carbon|null                            $created_at
 * @property \Illuminate\Support\Carbon|null                            $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereParentGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Group[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Block[] $blocks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Group[] $childGroups
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Event[] $events
 * @property-read \App\Group|null                                       $parentGroup
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Task[]  $tasks
 * @property string|null                                                $main_event_id
 * @property-read \App\Event|null                                       $mainEvent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereMainEventId($value)
 * @property string|null                                                $chat
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereChat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group query()
 */
class Group extends Model
{
    protected $fillable
        = [
            'name',
            'parent_group_id',
            'main_event_id',
        ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

    public function childGroups()
    {
        return $this->hasMany(Group::class, 'parent_group_id');
    }

    public function parentGroup()
    {
        return $this->belongsTo(Group::class, 'parent_group_id');
    }

    public function sayMembersCount()
    {
        return $this->sayCount($this->users()->count(), 'člen', 'členové', 'členů');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function mainEvent()
    {
        return $this->belongsTo(Event::class, 'main_event_id');
    }


    public function item_places()
    {
        return $this->hasMany(ItemPlace::class);
    }

    /**
     * @param $count
     * @param $one
     * @param $two
     * @param $five
     *
     * @return mixed
     */
    public function sayCount(int $count, $one, $two, $five)
    {
        if ($count == 0)
        {
            return $count . " " . $five;
        }
        if ($count == 1)
        {
            return $count . " " . $one;
        }
        elseif ($count >= 2 && $count <= 4)
        {
            return $count . " " . $two;
        }
        else
        {
            return $count . " " . $five;
        }
    }

    public function checkIfAuthBelongsTo()
    {
        return ! empty($this->users()->find(Auth::id()));
    }

    public function checkIfUserBelongsTo(User $user)
    {
        return ! empty($this->users()->find($user->id));
    }

    public function getUserRole(User $user)
    {
        if ( ! empty($this->users()->find($user->id)))
        {
            return $this->users()->withPivot('role')->find($user->id)->pivot->role;
        }
        else
        {
            return null;
        }
    }

    /**
     * If group has no parent, is top level.
     */
    public function isTopLevel()
    {
        if ($this->parentGroup()->count() == 0)
        {
            return true;
        }

        return false;
    }

    /**
     * Ověří, zda je přihlášený uživatel adminem skupiny.
     *
     * @return bool
     */
    public function checkIfAuthAdmin()
    {
        $role = $this->getUserRole(Auth::user());

        if ($role == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getUsersToAdd()
    {
        // Pokud je skupina na nejvyšší úrovni, nabídne všechny nepřidané.
        if (empty($this->parent_group_id))
        {
            $users_to_add = [];

            foreach (User::all() as $user)
            {
                $user_search = $this->users->find($user->id);

                if ($user_search === null)
                {
                    $users_to_add[] = $user;
                }
            }

            return $users_to_add;
        }
        // Jinak nabídne lidi ze skupiny.
        else
        {
            $users_to_add = [];

            foreach ($this->parentGroup->users as $user)
            {
                $user_search = $this->users->find($user->id);

                if ($user_search === null)
                {
                    $users_to_add[] = $user;
                }
            }

            return $users_to_add;
        }
    }

    /**
     * Child groups whose member is logged user.
     *
     * @return array|mixed
     */
    public function myGroups()
    {
        return $this->childGroups->intersect(Auth::user()->groups);
    }

    public function otherGroups()
    {
        return $this->childGroups->diff($this->myGroups());
    }

    public function getAbbr()
    {
        return substr($this->name, 0, 3);
    }
}
