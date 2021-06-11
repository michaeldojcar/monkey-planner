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

        $this->validate($request, [
            'q' => 'required|string',
        ]);

        $results = Ob::with('type')
            ->where('name', 'like', "%$q%")
            ->get();

        return new Response($results);
    }
}
