<?php

namespace App;

use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Task
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Task whereContent($value)
 * @method static Builder|Task whereCreatedAt($value)
 * @method static Builder|Task whereId($value)
 * @method static Builder|Task whereName($value)
 * @method static Builder|Task whereStatus($value)
 * @method static Builder|Task whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|Event[] $events
 * @property-read Collection|Group[] $groups
 * @property-read Collection|User[] $users
 * @property int $type
 * @property int|null $item_id
 * @property int|null $required_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereRequiredCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereType($value)
 */
class Task extends Model
{
    public const TYPE_BASIC = 0;
    public const TYPE_ROLE = 1;
    public const TYPE_ITEM = 2;

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getTypeString()
    {
        switch ($this->status)
        {
            case 0:
                return 'úkol';
            case 1:
                return 'role v programu';
            case 2:
                return 'požadavek na rekvizitu';
            default:
                throw new Exception("Undefined type of task.");
        }
    }


    public function getStatusString()
    {
        switch ($this->status)
        {
            case 0:
                return 'Ready';
            case 1:
                return 'In progress';
            case 2:
                return 'Completed';
            default:
                return "Undefined";
        }
    }

    public function getMainEvent()
    {
        return $this->events()->where('parent_event_id', null)->first();
    }

    /**
     * @return Event
     */
    public function getSubEvent()
    {
        return $this->events()->where('parent_event_id', '!=', null)->first();
    }

    /**
     * Check if task is assigned to "all".
     *
     * @return bool
     */
    public function assignedToAll()
    {
        $main_event = $this->getMainEvent();

        if ($this->groups()->count() > 0 && $this->groups()->first()->id == $main_event->id)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getUnassignedUserPlacesCount()
    {
        return $this->required_count - $this->users()->count();
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
