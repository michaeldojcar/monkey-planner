<?php

namespace App\Http\Controllers\Manage;

use App\Block;
use App\Event;
use App\Group;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show event program view.
     *
     * @param  Event  $event
     *
     * @return Factory|View Array of collection for every day.
     */
    public function program(Event $event)
    {
        $group = $event->owner_group;

        return view('tabor_web.program.program', [
            'main_event' => $event,
            'group'      => $group,

            'days'       => $this->getEventsArray($event), // Days with events
            'days_count' => $this->getAllDaysCount($event), // Only count

            'non_scheduled' => $event->events()->where('is_scheduled', false)->orderBy('name')->get(),
        ]);
    }


    /**
     * Return carbon date from relative day.
     *
     * @param  Event  $parent_event
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
     * @param  Event  $event
     *
     * @return int
     */
    public function getAllDaysCount(Event $event)
    {
        $start_date = Carbon::parse($event->from);
        $diff       = $start_date->diffInDays($event->to, false);

        return $diff;
    }

    public function store($event_id, Request $request)
    {
        $main_event = Event::findOrFail($event_id);

        $event                  = new Event();
        $event->name            = $request['name'];
        $event->type            = $request['type'];
        $event->short           = $request['name'];
        $event->content         = $request['name'];
        $event->parent_event_id = $main_event->id;

        $start_date = $this->getDateFromRelativeDay($main_event, $request['day']);
        $start_date = $start_date->format('Y/m/d');
        $start_time = $request['time'];

        $event->from = Carbon::createFromFormat('Y/m/d H:i', $start_date.' '.$start_time);
        $event->to   = Carbon::parse($event->from." + 1 hour");
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

    /**
     * @param $main_event_id
     * @param $event_id
     *
     * @return Application|Factory|View
     */
    public function edit($main_event_id, $event_id)
    {
        $main_event = $this->findById($main_event_id);
        $event      = $this->findById($event_id);

        return view('tabor_web.events.edit', [
            'group' => $main_event->owner_group,
            'event' => $event,

            'main_event' => $main_event,

            'days'                  => $this->getEventsArray($main_event), // Days with events
            'days_count'            => $this->getAllDaysCount($main_event), // Only count

            // Data for Magic suggest
            'author_users'          => $main_event->owner_group->users,
            'author_users_selected' => $event->authors()->get(),

            'author_groups'          => $main_event->owner_group->childGroups,
            'author_groups_selected' => $event->groups,

            'garant_users'          => $main_event->owner_group->users,
            'garant_users_selected' => $event->garants()->get(),
        ]);
    }

    /**
     * Update event.
     *
     * @param $event_id
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function update($event_id, Request $request)
    {
        $event = $this->findById($event_id);

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
                $start_date = $this->getDateFromRelativeDay($event->parentEvent, $request['day']);
                $start_date = $start_date->format('Y/m/d');

                // Time from
                $start_time  = $request['time_from'];
                $event->from = Carbon::createFromFormat('Y/m/d H:i', $start_date.' '.$start_time);

                // Time to
                $end_time  = $request['time_to'];
                $event->to = Carbon::createFromFormat('Y/m/d H:i', $start_date.' '.$end_time);
            }
            else
            {
                $event->is_scheduled = false;
            }
        }
        else
        {
            $event->content = $request['content'];
            $event->notice  = $request['notice'];
        }

        // Save model
        $event->save();

        // Sync related group
        $event->groups()->sync($request['author_groups']);

        // Sync related users
        $event->users()->withPivotValue('status', 5)->sync($request['author_users']);
        $event->users()->withPivotValue('status', 4)->sync($request['garant_users']);


        if ( ! $event->isMainEvent())
        {
            return redirect()->route('organize.events.show', [$event->parentEvent, $event]);
        }
        else
        {
            return redirect()->route('organize.program', $event);
        }
    }

    public function getEventsFromDay(Event $main_event, $day_num)
    {
        $date = $this->getDateFromRelativeDay($main_event, $day_num);

        $events = $main_event->events();

        return $events->whereDate('from', '=', $date)->where('is_scheduled', true)->orderBy('from')->get();
    }

    public function getEventsArray(Event $main_event)
    {
        $max_day_count = $this->getAllDaysCount($main_event);

        $days = [];

        for ($x = 0; $x <= $max_day_count; $x++)
        {
            $days[$x] = $this->getEventsFromDay($main_event, $x);
        }

        return $days;
    }

    public function show($main_event_id, $sub_event_id)
    {
        $main_event = $this->findById($main_event_id);
        $sub_event  = $this->findById($sub_event_id);

        return view('tabor_web.events.show', [
            'group' => $main_event->owner_group,
            'event' => $sub_event,

            'main_event' => $main_event
        ]);
    }

    private function createBlock(Event $event, $title, $content = "")
    {
        $block           = new Block();
        $block->event_id = $event->id;
        $block->title    = $title;
        $block->content  = $content;
        $block->save();
    }


    public function storeBlock(Event $event, Request $request)
    {
        $block           = new Block();
        $block->event_id = $event->id;
        $block->title    = $request['title'];
        $block->save();

        return redirect()->route('organize.blocks.edit', [$event, $block]);
    }

    public function editBlock(Event $event, Block $block)
    {
        return view('tabor_web.blocks.edit', [
            'block'      => $block,
            'group'      => $event->owner_group,
            'main_event' => $event,
        ]);
    }

    public function updateBlock(Event $event, Block $block, Request $request)
    {
        $block->fill($request->all());
        $block->save();

        if (isset($block->event_id))
        {
            return redirect()->route("organize.events.show", [$event, $block->event]);
        }
        else
        {
            return redirect()->route("organize.dashboard.subGroup", [$group, $block->group_id]);
        }
    }

    public function deleteBlock(Group $group, Block $block)
    {
        $block->delete();

        return redirect()->route("organize.event", [$group, $block->event]);
    }


    /**
     * @param  Group  $group
     * @param  Event  $event
     *
     * @return mixed
     * @throws Exception
     */
    public function delete(Group $group, Event $event)
    {
        $event->delete();

        return redirect()->route('organize.program', $group);
    }

    private function findById($id)
    {
        return Event::findOrFail($id);
    }
}
