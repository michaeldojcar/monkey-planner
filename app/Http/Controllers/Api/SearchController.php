<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Ob;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->input('q');

        $results = Ob::where('name', 'LIKE', "%$q%")->with('type')->get();

        return new Response($results);
    }
}
