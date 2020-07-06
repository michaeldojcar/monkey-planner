<?php

namespace App\Http\Controllers;

use App\Event;
use App\Sms\BasicEventNotification;
use App\User;

class SmsController extends Controller
{
    /**
     * Pošle SMS všem členům eventu.
     *
     * @param Event $event
     */
    public function sendEventActiveMembers(Event $event)
    {
        foreach ($event->users as $member)
        {
            $this->sendSms($member, $event);
        }
    }

    public function sendSms(User $user, $event)
    {
        $sms = new BasicEventNotification($user, $event);
        $sms->send();
    }
}
