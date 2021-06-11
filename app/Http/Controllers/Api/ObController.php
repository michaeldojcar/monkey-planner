<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Ob;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ObController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param $uuid
     *
     * @return Response
     */
    public function show($uuid): Response
    {
        $ob = Ob::where('uuid', $uuid)->firstOrFail()->load('type');

        return new Response($ob);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
