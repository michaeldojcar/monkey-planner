<?php

namespace App\Http\Controllers\Manage;

use App\Block;
use App\Event;
use App\Group;
use Carbon\Carbon;
use DemeterChain\B;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EventPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Výpis programu (harmonogram všech událostí).
     *
     * @param Group $group
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View Pole kolekcí na každý den.
     */
    public function program(Group $group)
    {
        \Auth::user()->last_login_at = Carbon::now();
        Auth::user()->save();

        $main_event = $group->mainEvent;

        return view('tabor_web.program', [
            'group'         => $group,
            'days'          => $this->getEventsArray($main_event), // Days with events
            'days_count'    => $this->getAllDaysCount($main_event), // Only count
            'non_scheduled' => $group->mainEvent->events()->where('is_scheduled', false)->orderBy('name')->get(),
        ]);
    }


    /**
     * Return carbon date from relative day.
     *
     * @param Event $parent_event
     * @param       $day_num
     *
     * @return Carbon
     */
    public function getDateFromRelativeDay(Event $parent_event, $day_num)
    {
        $main_date  = Carbon::parse($parent_event->from);
        $result_day = $main_date->addDays($day_num);

        return $result_day;
    }

    /**
     * Returns count of all days in event.
     *
     * @param Event $event
     *
     * @return int
     */
    public function getAllDaysCount(Event $event)
    {
        $start_date = Carbon::parse($event->from);
        $diff       = $start_date->diffInDays($event->to, false);

        return $diff;
    }

    public function store(Group $group, Request $request)
    {
        $event                  = new Event();
        $event->name            = $request['name'];
        $event->type            = $request['type'];
        $event->short           = $request['name'];
        $event->content         = $request['name'];
        $event->parent_event_id = $group->mainEvent->id;

        $start_date = $this->getDateFromRelativeDay($group->mainEvent, $request['day']);
        $start_date = $start_date->format('Y/m/d');
        $start_time = $request['time'];

        $event->from = Carbon::createFromFormat('Y/m/d H:i', $start_date . ' ' . $start_time);
        $event->to   = Carbon::parse($event->from . " + 1 hour");
        $event->save();

        // Default info blocks.
        if ($event->type == 0) // Event
        {
            $this->createBlock($event, "Obecné informace");
        }
        if ($event->type == 1) // Game
        {
            $this->createBlock($event, "Motivace");
            $this->createBlock($event, "Scénka");
            $this->createBlock($event, "Stručný popis pravidel", 'Stručný popis pravidel - 3 věty max.');
            $this->createBlock($event, "Pravidla hry");
            $this->createBlock($event, "Hrají");

        }
        if ($event->type == 2) // Part of program
        {
            $this->createBlock($event, "Obecné informace");
        }
        if ($event->type == 3) // Technical
        {
            $this->createBlock($event, "Obecné informace");
        }
        if ($event->type == 4) // Event
        {
            $this->createBlock($event, "Obecné informace");
        }

        return redirect()->back();
    }

    public function edit(Group $group, Event $event)
    {
        $main_event = $group->mainEvent;

        return view('tabor_web.events.edit', [
            'group'                 => $group,
            'event'                 => $event,
            'days'                  => $this->getEventsArray($main_event), // Days with events
            'days_count'            => $this->getAllDaysCount($main_event), // Only count

            // Data for Magic suggest
            'author_users'          => $group->users,
            'author_users_selected' => $event->authors()->get(),

            'author_groups'          => $group->childGroups,
            'author_groups_selected' => $event->groups,

            'garant_users'          => $group->users,
            'garant_users_selected' => $event->garants()->get(),
        ]);
    }

    /**
     * Update event.
     *
     * @param Group   $group
     * @param Event   $event
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Group $group, Event $event, Request $request)
    {
        $event->name = $request['name'];

        if ($request->has('type'))
        {
            $event->type = $request['type'];
        }

        $event->place = $request['place'];

        // Change date and time (sub event only)
        if ( ! $event->isMainEvent())
        {
            if ($request['day'] != 'all')
            {
                // Compute Carbon date
                $start_date = $this->getDateFromRelativeDay($group->mainEvent, $request['day']);
                $start_date = $start_date->format('Y/m/d');

                // Time from
                $start_time  = $request['time_from'];
                $event->from = Carbon::createFromFormat('Y/m/d H:i', $start_date . ' ' . $start_time);

                // Time to
                $end_time  = $request['time_to'];
                $event->to = Carbon::createFromFormat('Y/m/d H:i', $start_date . ' ' . $end_time);
            }
            else
            {
                $event->is_scheduled = false;
            }
        }
        else {
            $event->content = $request['content'];
            $event->notice = $request['notice'];
        }


        // Author group
        $event->groups()->sync($request['author_groups']);

        // Garants
        $event->users()->withPivotValue('status', 5)->sync($request['author_users']);
        $event->users()->withPivotValue('status', 4)->sync($request['garant_users']);


        $event->save();

        if ( ! $event->isMainEvent())
        {
            return redirect()->route('organize.event', [$group, $event]);
        }
        else
        {
            return redirect()->route('organize.program', $group);
        }
    }

    public
    function getEventsFromDay(
        Event $main_event,
        $day_num
    ) {
        $date = $this->getDateFromRelativeDay($main_event, $day_num);

        $events = $main_event->events();

        return $events->whereDate('from', '=', $date)->where('is_scheduled', true)->orderBy('from')->get();
    }

    public
    function getEventsArray(
        Event $main_event
    ) {
        $max_day_count = $this->getAllDaysCount($main_event);

        $days = [];

        for ($x = 0; $x <= $max_day_count; $x++)
        {
            $days[$x] = $this->getEventsFromDay($main_event, $x);
        }

        return $days;
    }

    public
    function show(
        Group $group,
        Event $event
    ) {
        return view('tabor_web.events.show', [
            'group' => $group,
            'event' => $event,
        ]);
    }

    private
    function createBlock(
        $event,
        $title,
        $content = ""
    ) {
        $block           = new Block();
        $block->event_id = $event->id;
        $block->title    = $title;
        $block->content  = $content;
        $block->save();
    }


    public
    function storeBlock(
        Group $group,
        Event $event,
        Request $request
    ) {
        $block           = new Block();
        $block->event_id = $event->id;
        $block->title    = $request['title'];
        $block->save();

        return redirect()->route('organize.block.edit', [$group, $block]);
    }

    public
    function editBlock(
        Group $group,
        Block $block
    ) {
        return view('tabor_web.blocks.edit')->withBlock($block)->withGroup($group);
    }

    public
    function updateBlock(
        Group $group,
        Block $block,
        Request $request
    ) {
        $block->fill($request->all());
        $block->save();

        // dd($block->event->groups->first());
        if (isset($block->event_id))
        {
            return redirect()->route("organize.event", [$group, $block->event]);
        }
        else
        {
            return redirect()->route("organize.dashboard.subGroup", [$group, $block->group_id]);
        }
    }

    public
    function deleteBlock(
        Group $group,
        Block $block
    ) {
        $block->delete();

        return redirect()->route("organize.event", [$group, $block->event]);
    }


    /**
     * @param Group $group
     * @param Event $event
     *
     * @return mixed
     * @throws \Exception
     */
    public
    function delete(
        Group $group,
        Event $event
    ) {
        $event->delete();

        return redirect()->route('organize.program', $group);
    }
}
