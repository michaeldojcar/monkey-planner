<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\ItemPlace;
use App\Repositories\ItemPlaceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * @var ItemPlaceRepository
     */
    private $itemPlaceRepository;


    public function __construct(ItemPlaceRepository $placeRepository)
    {
        $this->itemPlaceRepository = $placeRepository;
    }


    /**
     * All my inventories (main inventory locations).
     */
    public function index()
    {
        return view('user.inventory.index', [
            'places' => $this->itemPlaceRepository
                ->getMainItemPlacesForUser(Auth::user()),
        ]);
    }
}
