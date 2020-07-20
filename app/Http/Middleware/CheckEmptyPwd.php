<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckEmptyPwd
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If pwd is '123456'
        if (Auth::user()->reset_password)
        {
            return redirect()->route('new-pwd');
        }

        // Move to middleware
        Auth::user()->last_login_at = Carbon::now();
        Auth::user()->save();

        return $next($request);
    }
}
