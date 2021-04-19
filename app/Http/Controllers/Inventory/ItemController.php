<?php

namespace App\Http\Controllers\Inventory;

use App\Group;
use App\Http\Controllers\Controller;
use App\Item;
use App\ItemPlace;
use App\ItemState;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use MichaelDojcar\LaravelPhoto\Models\Photo;
use MichaelDojcar\LaravelPhoto\PhotoService;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index($group_id)
    {
        $group = $this->findGroup($group_id);

        return view('inventory.item.index', [
            'group' => $group,
            'items' => $group->items,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create($group_id, Request $request)
    {
        $group = $this->findGroup($group_id);

        if ($request->has('place_id'))
        {
            $place_id = $request->input('place_id');
            $place    = ItemPlace::findOrFail($place_id);
        }
        else
        {
            $place = null;
        }

        if ($request->has('item_id'))
        {
            $item_id = $request->input('item_id');
            $item    = Item::findOrFail($item_id);
        }
        else
        {
            $item = null;
        }

        $available_items  = $group->items;
        $available_places = $group->item_places;

        return view('inventory.item.create', [
            'place'            => $place,
            'item'             => $item,
            'group'            => $group,

            // Data for magic picker
            'available_items'  => $available_items,
            'available_places' => $available_places,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param         $group_id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store($group_id, Request $request)
    {
        $place = ItemPlace::findOrFail($request['place_id'])->first();

        // Creating new item
        if ($request['select_item_type'] == 'new')
        {
            $item             = new Item();
            $item->name       = $request['name'];
            $item->group_id   = $this->findGroup($group_id)->id;
            $item->count_unit = 'ks';
            $item->save();

            $state           = new ItemState();
            $state->item_id  = $item->id;
            $state->place_id = $place->id;
            $state->count    = $request['count'];
            $state->state    = 0;
            $state->save();
        }

        // Adding record to existing item
        else
        {
            $item = Item::findOrFail($request['existing_item_id'])->first();

            $state = $item->item_states->where('place_id', $place->id)->first();

            if ($state)
            {
                $state->count = $state->count + $request['count'];
                $state->save();
            }

            else
            {
                $state           = new ItemState();
                $state->item_id  = $item->id;
                $state->count    = $request['count'];
                $state->place_id = $place->id;
                $state->state    = 0;
                $state->save();
            }


        }

        return redirect()->route('inventory.items.show', [$group_id, $item->id]);
    }


    public function uploadPhoto($group_id, Request $request)
    {
        $group = $this->findGroup($group_id);
        $item  = Item::findOrFail($request['item_id']);

        $ps             = new PhotoService();
        $photo          = $ps->create($item->name, $request->file('photo'));
        $photo->item_id = $item->id;
        $photo->save();

        return redirect()->route('inventory.items.show', [$group, $item->id]);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Application|Factory|View
     */
    public function show($group_id, $id)
    {
        $group = $this->findGroup($group_id);
        $item  = Item::findOrFail($id);

        return view('inventory.item.show', [
            'group' => $group,
            'item'  => $item,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Application|Factory|View
     */
    public function edit($group_id, $id)
    {
        $group = $this->findGroup($group_id);
        $item  = Item::findOrFail($id);

        return view('inventory.item.edit', [
            'group' => $group,
            'item'  => $item,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param         $group_id
     * @param int     $id
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update($group_id, $id, Request $request)
    {
        $group = $this->findGroup($group_id);
        $item  = Item::findOrFail($id);

        $item->name        = $request['name'];
        $item->description = $request['description'];
        $item->count_unit  = $request['count_unit'];
        $item->save();

        return redirect()->route('inventory.items.show', [$group, $item->id]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($group_id, $id)
    {
        $group = $this->findGroup($group_id);
        $item  = Item::findOrFail($id);
        $item->item_states()->delete();

        $ps = new PhotoService();
        foreach ($item->photos as $photo)
        {
            $ps->delete($photo);
        }

        $item->delete();

        return redirect()->route('inventory.items.index', [$group]);
    }


    private function findGroup(int $group_id)
    {
        return Group::findOrFail($group_id);
    }
}
