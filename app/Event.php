<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Event
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $datetime
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection|UserEventParticipation[] $userParticipation
 * @property-read Collection|User[] $users
 * @method static Builder|Event whereCreatedAt($value)
 * @method static Builder|Event whereDatetime($value)
 * @method static Builder|Event whereId($value)
 * @method static Builder|Event whereName($value)
 * @method static Builder|Event whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string $from
 * @property string $place
 * @method static Builder|Event whereFrom($value)
 * @method static Builder|Event wherePlace($value)
 * @property int $type
 * @property string $short
 * @property string $content
 * @property string $to
 * @property string|null $parent_event_id
 * @method static Builder|Event whereContent($value)
 * @method static Builder|Event whereParentEventId($value)
 * @method static Builder|Event whereShort($value)
 * @method static Builder|Event whereTo($value)
 * @method static Builder|Event whereType($value)
 * @property-read Collection|Group[] $groups
 * @property-read Collection|Block[] $blocks
 * @property-read Collection|Event[] $events
 * @property-read Collection|Task[] $tasks
 * @property-read Event|null $parentEvent
 * @property-read Collection|Role[] $roles
 * @property int $is_scheduled
 * @method static Builder|Event newModelQuery()
 * @method static Builder|Event newQuery()
 * @method static Builder|Event query()
 * @method static Builder|Event whereIsScheduled($value)
 * @property-read Collection|Task[] $basicTasks
 * @property-read Collection|Task[] $itemTasks
 * @property-read Collection|Task[] $roleTasks
 * @property-read Collection|User[] $authors
 * @property-read Collection|User[] $garants
 */
class Event extends Model
{
    protected $fillable
        = [
            'name',
            'type',
            'short',
            'content',
            'from',
            'to',
            'parent_event_id',
        ];

    protected $dates
        = [
            'from',
            'to',
        ];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function garants()
    {
        return $this->belongsToMany(User::class)->wherePivot('status', 4);
    }

    public function authors()
    {
        return $this->belongsToMany(User::class)->wherePivot('status', 5);
    }

    public function owner_group()
    {
        return $this->belongsTo(Group::class, 'owner_group_id');
    }

    public function event_times()
    {
        return $this->hasMany(EventTime::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function basicTasks()
    {
        return $this->belongsToMany(Task::class)->where('type', 0);
    }

    public function roleTasks()
    {
        return $this->belongsToMany(Task::class)->where('type', 1);
    }

    public function itemTasks()
    {
        return $this->belongsToMany(Task::class)->where('type', 2);
    }

    public function getAuthUserParticipationStatus()
    {
        return $this->getUserParticipationStatus(Auth::user());
    }

    /**
     * Vrátí status uživatele na dané události.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function getUserParticipationStatus(User $user)
    {
        if ( ! empty($this->users()->find($user->id)))
        {
            return $this->belongsToMany(User::class)->withPivot('status')->find($user->id)->pivot->status;
        }
        else
        {
            return null;
        }
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'parent_event_id');
    }

    public function parentEvent()
    {
        return $this->belongsTo(Event::class, 'parent_event_id');
    }

    public function isMainEvent()
    {
        if ($this->parent_event_id == null)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getNextSubEvent()
    {
        $parentEvents = $this->parentEvent->events->where('is_scheduled', true)->sortBy('from');

        $collection = $parentEvents->getIterator();

        while (current($collection)->id != $this->id)
        {
            next($collection);
        }

        $res = next($collection);

        if ( ! empty($res))
        {
            return $res;
        }
        else
        {
            return null;
        }
    }

    public function getPreviousSubEvent()
    {
        $parentEvents = $this->parentEvent->events->where('is_scheduled', true)->sortBy('from');

        $collection = $parentEvents->getIterator();

        while (current($collection)->id != $this->id)
        {
            next($collection);
        }

        $res = prev($collection);

        if ( ! empty($res))
        {
            return $res;
        }
        else
        {
            return null;
        }
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function notAssignedTasks()
    {
        return $this->tasks()->whereDoesntHave('users');
    }

    public function assignedTasks()
    {
        return $this->tasks()->whereHas('users');
    }

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

    public function getTypeString()
    {
        if ($this->type == 0)
        {
            return 'událost';
        }
        elseif ($this->type == 1)
        {
            return 'hra';
        }
        elseif ($this->type == 2)
        {
            return 'program';
        }
        elseif ($this->type == 3)
        {
            return 'režim';
        }
        elseif ($this->type == 4)
        {
            return 'přednáška';
        }
        elseif ($this->type == 5)
        {
            return 'duchovní';
        }
        elseif ($this->type == 6)
        {
            return 'scénka';
        }
        else
        {
            throw new Exception('Neznámý typ eventu');
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getTypeEmoji()
    {
        if ($this->type == 0)
        {
            return '📅';
        }
        elseif ($this->type == 1)
        {
            return '🎲';
        }
        elseif ($this->type == 2)
        {
            return '💡';
        }
        elseif ($this->type == 3)
        {
            return '⌚';
        }
        elseif ($this->type == 4)
        {
            return '📽';
        }
        elseif ($this->type == 5)
        {
            return '✝';
        }
        elseif ($this->type == 6)
        {
            return '📽';
        }
        else
        {
            throw new Exception('Neznámý typ eventu');
        }
    }

    /**
     * Counts the relative day count according to related event.
     *
     * @return int
     */
    public function getDayNumber()
    {
        $date      = Carbon::parse($this->parentEvent->from)->startOfDay();
        $main_date = Carbon::parse($this->from);

        $diff = $date->diffInDays($main_date, false);

        return $diff;
    }

    /**
     * Useful for parent events.
     *
     * @param $day_num
     *
     * @return Carbon|CarbonInterface
     */
    public function countDateFromThisEventsDayNumber($day_num)
    {
        $main_date  = Carbon::parse($this->from);
        $result_day = $main_date->addDays($day_num);

        return $result_day;
    }

    public function getAllDaysCount()
    {
        $start_date = Carbon::parse($this->from);
        $diff       = $start_date->diffInDays($this->to, false);

        return $diff;
    }
}
