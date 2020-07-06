<?php

namespace App\Http\Controllers\PublicPortal;

use App\Event;
use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckEmptyPwd;
use App\Sms\BasicEventNotification;
use App\Sms\CustomEventNotification;
use App\User;
use App\UserEventParticipation;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class DashController
 *
 * Public views of portal.
 *
 * @package App\Http\Controllers\PublicPortal
 */
class DashController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale('cs');
    }

    public function dashboard()
    {
        // Online users counter.
        $this->updateCounter();

        return view('dashboard', [
            'upcoming' => Auth::user()->events()
                ->where('from', '>', Carbon::now())
                ->orderBy('from')
                ->where('parent_event_id',0)
                ->get()->take(10),

            'online' => User::where('updated_at', '>', Carbon::now()->subMinutes(5))->get(),

            'groups' => Auth::user()->groups->where('parent_group_id', null),
        ]);
    }

    public function group($id)
    {
        // Online users counter.
        $this->updateCounter();

        $group = Group::findOrFail($id);

        $this->checkIfAuthFromGroup($group);

        return View('group', [
            'upcoming' => $group->events()->where('to', '>', Carbon::now('europe/prague'))
                ->orderBy('from')
                ->get()
                ->take(10),

            'group'     => $group,
            'subgroups' => $group->childGroups()->get(),
        ]);
    }

    public function event($id)
    {
        $this->updateCounter();

        $event = Event::findOrFail($id);

        return View('event', [
            'event' => $event,
        ]);
    }

    public function createEvent($event_id)
    {
        return view('create_event', [
            'event_id' => $event_id,
        ]);
    }

    public function storeCreateEvent(Request $request)
    {

    }

    public function setAuthUserEventStatus($event_id, $status)
    {
        return $this->setUserEventStatus($event_id, Auth::id(), $status);
    }

    public function setUserEventStatus($event_id, $user_id, $status)
    {
        $events = UserEventParticipation::whereEventId($event_id)->where('user_id', $user_id);

        if ($events->count() > 0)
        {
            $participation = $events->first();
        }
        else
        {
            $participation = new UserEventParticipation();
        }

        $participation->event_id = $event_id;
        $participation->user_id  = $user_id;

        $participation->role = $status;
        $participation->save();

        return redirect()->back();
    }

    /**
     * Přidá členy přiřazené skupiny k události.
     * Pokud už je člen nějakým způsobem pozván, nepřidá jej.
     *
     * @param $event_id
     * @param $status
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addEventGroupMembersWithStatus($event_id, $status)
    {
        $event = Event::findOrFail($event_id);

        $users = $event->groups()->first()->users; // TODO: zatím bere jen první přiřazenou skupinu.

        /* @var $user User */
        foreach ($users as $user)
        {
            $this->addEventGroupMemberWithStatus($user, $event, $status);
        }

        return redirect()->back();
    }

    /**
     * Přidá člena k události, pokud ještě nemá status.
     *
     * @param       $user
     * @param Event $event
     * @param int   $status
     */
    private function addEventGroupMemberWithStatus($user, Event $event, int $status)
    {
        if (empty($event->users->find($user->id)))
        {
            $this->setUserEventStatus($event->id, $user->id, $status);
        }
    }

    private function updateCounter()
    {
        // Obnoví updated_at pro počítadlo.
        $user             = Auth::user();
        $user->updated_at = Carbon::now('europe/prague');
        $user->save();

    }

    /**
     * Zkontroluje, jestli user patří do skupiny.
     *
     * @param Group $group
     *
     * @return bool
     */
    private function checkIfAuthFromGroup(Group $group)
    {
        return ! empty($group->users()->findOrFail(Auth::id()));
    }

    public function addUserToGroup($group_id, $user_id)
    {
        $group = Group::findOrFail($group_id);
        $user  = User::findOrFail($user_id);

        $group->users()->attach($user->id);

        return redirect()->back();
    }

    public function sendMembersSms($id)
    {
        $event = Event::findOrFail($id);

        foreach ($event->users as $user)
        {
            $sms = new BasicEventNotification($user, $event);
            $sms->send();
        }
    }

    public function sendMembersSmsCustom(Request $request)
    {
        $event = Event::findOrFail($request['event_id']);

        foreach ($event->users as $user)
        {
            $sms = new CustomEventNotification($user, $event, $request['msg']);
            $sms->send();
        }

        return redirect()->back();
    }

    public function songs()
    {

    }

    /**
     * Admin
     */
    public function adminDash()
    {
        return view('admin.dashboard');
    }

}
