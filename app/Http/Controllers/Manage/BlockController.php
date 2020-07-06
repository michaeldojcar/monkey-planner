<?php

namespace App\Http\Controllers\Manage;

use App\Block;
use App\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Group $group)
    {
        return view('tabor_web.blocks.index', [
            'group'  => $group,
            'blocks' => $group->blocks,
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
