<?php

namespace App\Http\Controllers\Manage;

use App\Block;
use App\Event;
use App\Group;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param  Group  $group
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @deprecated
     */
    public function index(Group $group)
    {
        return view('tabor_web.blocks.index', [
            'group'  => $group,
            'blocks' => $group->blocks,
        ]);
    }



    public function createBlock(Event $event, $title, $content = "")
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



    public function editBlock(Event $event, Block $block)
    {
        return view('tabor_web.blocks.edit', [
            'block'      => $block,
            'group'      => $event->owner_group,
            'main_event' => $event,
        ]);
    }

    public function storeSubGroupBlock(Group $group, Group $subgroup, Request $request)
    {
        $block           = new Block();
        $block->group_id = $subgroup->id;
        $block->title    = $request['title'];
        $block->save();

        return redirect()->back();
    }
}
