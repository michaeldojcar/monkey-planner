<?php

namespace App;

use Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use PhpParser\Node\Stmt\Echo_;

/**
 * App\User
 *
 * @property int                                                                                                            $id
 * @property int|null                                                                                                       $role_id
 * @property string                                                                                                         $name
 * @property string                                                                                                         $email
 * @property string|null                                                                                                    $avatar
 * @property string|null                                                                                                    $email_verified_at
 * @property string                                                                                                         $password
 * @property string|null                                                                                                    $remember_token
 * @property array|null                                                                                                     $settings
 * @property \Illuminate\Support\Carbon|null                                                                                $created_at
 * @property \Illuminate\Support\Carbon|null                                                                                $updated_at
 * @property mixed                                                                                                          $locale
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \TCG\Voyager\Models\Role|null                                                                             $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Role[]                                       $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string                                                                                                         $surname
 * @property string                                                                                                         $name_5
 * @property string                                                                                                         $phone
 * @property string|null                                                                                                    $street
 * @property string|null                                                                                                    $town
 * @property string|null                                                                                                    $postal
 * @property string|null                                                                                                    $country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTown($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[]                                                      $groups
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Event[]                                                     $events
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Task[]                                                      $tasks
 * @property int                                                                                                            $reset_password
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereResetPassword($value)
 * @property-read mixed                                                                                                     $whole_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Task[]                                                      $basicTasks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Task[]                                                      $itemTasks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Task[]                                                      $roleTasks
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'name',
            'surname',
            'name_5',
            'email',
            'surname',
            'phone',
            'town',
            'street',
            'postal',
            'country',
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden
        = [
            'password',
            'remember_token',
        ];

    protected $appends = ['whole_name'];

    protected $dates = ['last_login_at'];

    /**
     * Každý uživatel může být přiřazen k neomezenému počtu skupin.
     * U každé skupiny má uživatel přiřazenu roli (0 = člen/1 = správce).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class)->withPivot('role');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
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


    /**
     * Celé jméno.
     *
     * @return string
     */
    public function getWholeName()
    {
        return $this->name . " " . $this->surname;
    }

    public function getNick(Event $event)
    {

        if ( ! empty($this->events->find($event->id)->pivot->nick))
        {
            return $this->events->find($event->id)->pivot->nick;
        }
        else
        {
            return mb_strtoupper($this->name) . ' ' . mb_substr($this->surname, 0, 1) . '.';
        }
    }

    public function getWholeNameAttribute()
    {
        return $this->name . " " . $this->surname;
    }

    public function countBeforeOccupancy()
    {
        return ($this->basicTasks()->count() * 1 +
                $this->events()->wherePivot('status', 5)->count() * 2 +
                $this->roleTasks()->count() * 0.3 +
                $this->itemTasks()->count() * 1) / 20 * 100;
    }

    public function countEventOccupancy()
    {
        return ($this->basicTasks()->count() * 0.2 +
                $this->events()->wherePivot('status', 4)->count() * 3 +
                $this->roleTasks()->count() * 1.5 +
                $this->itemTasks()->count() * 0.2) / 20 * 100;
    }

    public function countOccupancy()
    {
        return ($this->countBeforeOccupancy() + $this->countEventOccupancy()) / 2;
    }

}
