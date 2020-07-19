<?php

namespace App\Http\Controllers\Admin;

use App\Group;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return View
     * @throws Exception
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.users.create')->withGroups(Group::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $user = new User();

        $user->fill($request->all());

        $user->password       = bcrypt('123456');
        $user->reset_password = true;

        $user->save();

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     *
     * @return Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit')->withUser($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     *
     * @return RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $user->fill($request->all());

        if ($request->has('reset_password'))
        {
            $user->password       = bcrypt('123456');
            $user->reset_password = true;
        }

        $user->save();

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index');
    }
}
