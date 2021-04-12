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
            'places' => $this->itemPlaceRepository->getMainItemPlacesForGroup($group)
        ]);
    }


    /**
     * Show item place.
     *
     * @param $id
     *
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $itemPlace = ItemPlace::findOrFail($id);

        return view('inventory.item_places.show', [
            'place' => $itemPlace,
        ]);
    }


}
