<?php

namespace App\Http\Controllers;

use App\Ob;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
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
     * @param Ob $ob
     *
     * @return Application|Factory|View|Response
     */
    public function show($ob_id)
    {
        $ob = Ob::findOrFail($ob_id);

        return view('object.show', [
            'ob' => $ob,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Ob $ob
     *
     * @return Response
     */
    public function edit(Ob $ob)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Ob      $ob
     *
     * @return Response
     */
    public function update(Request $request, Ob $ob)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Ob $ob
     *
     * @return Response
     */
    public function destroy(Ob $ob)
    {
        //
    }
}
