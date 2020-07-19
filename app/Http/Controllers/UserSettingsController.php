<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSettingsController extends Controller
{
    public function emptyPassword()
    {
        return view('auth.new-pwd');
    }

    public function storeNewPassword(Request $request)
    {
        $user = Auth::user();

        $user->password       = bcrypt($request['password']);
        $user->reset_password = false;

        $user->save();

        return redirect()->route('user.events.index');
    }
}
