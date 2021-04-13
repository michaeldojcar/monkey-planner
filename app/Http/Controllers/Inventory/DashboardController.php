<?php

namespace App\Http\Controllers\Inventory;

use App\Group;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard($group_id)
    {
        $group = Group::findOrFail($group_id);

        return view('inventory.dashboard.index', [
            'main_group'       => $group,
            'item_count'       => $group->items()->count(),
            'place_count'      => $group->item_places()->count(),
            'main_place_count' => $group->item_places()->where('parent_id', null)->count(),
        ]);
    }
}
