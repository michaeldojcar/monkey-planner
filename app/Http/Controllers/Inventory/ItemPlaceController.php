<?php

namespace App\Http\Controllers\Inventory;

use App\Group;
use App\Http\Controllers\Controller;
use App\ItemPlace;
use App\Repositories\ItemPlaceRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ItemPlaceController extends Controller
{
    /**
     * @var ItemPlaceRepository
     */
    private $itemPlaceRepository;


    public function __construct(ItemPlaceRepository $itemPlaceRepository)
    {
        $this->itemPlaceRepository = $itemPlaceRepository;
    }


    /**
     * Show group item places.
     *
     * @return Application|Factory|View
     */
    public function index($group_id)
    {
        $group = Group::findOrFail($group_id);

        return view('inventory.item_places.index', [
            'group'  => $group,
            'places' => $this->itemPlaceRepository->getMainItemPlacesForGroup($group),
        ]);
    }


    /**
     * Show item place.
     *
     * @param $group_id
     * @param $id
     *
     * @return Application|Factory|View
     */
    public function show($group_id, $id, Request $request)
    {
        $itemPlace = ItemPlace::findOrFail($id);

        return view('inventory.item_places.show', [
            'group' => $this->getMainGroup($request),
            'place' => $itemPlace,
        ]);
    }


    public function create(Request $request)
    {
        $group = $this->getMainGroup($request);

        if ($request->has('parent_id'))
        {
            $parent_place_id = $request->get('parent_id');
            $parent_place    = ItemPlace::findOrFail($parent_place_id);
        }
        else
        {
            $parent_place = null;
        }

        return view('inventory.item_places.create', [
            'parent_place' => $parent_place,
            'group'        => $group,
        ]);
    }


    public function store(Request $request)
    {
        $group = Group::findOrFail($request->route('group_id'));

        $place           = new ItemPlace();
        $place->name     = $request['name'];
        $place->group_id = $group->id;

        if ($request->has('parent_id'))
        {
            $place->parent_id = $request['parent_id'];
        }
        $place->save();

        return redirect()->route('inventory.item_places.show', [$group, $place]);
    }


    public function print($inventory_id, $place_id)
    {
        $item_place = ItemPlace::findOrFail($place_id);
        $main_place = ItemPlace::findOrFail($inventory_id);

        return view('inventory.item_places.print', [
            'main_place' =>  $main_place,
            'item_place' => $item_place,
        ]);
    }


    public function edit()
    {

    }


    private function getMainGroup(Request $request)
    {
        return Group::findOrFail($request->route('group_id'));
    }


}
