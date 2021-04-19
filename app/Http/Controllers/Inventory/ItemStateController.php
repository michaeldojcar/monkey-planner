<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\ItemState;
use Illuminate\Http\Request;

class ItemStateController extends Controller
{
    public function destroy($group_id, ItemState $itemState)
    {
        $itemState->delete();

        return redirect()->back();
    }
}
