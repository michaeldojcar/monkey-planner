<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Class AdminController
 *
 * Adminská zobrazení portálu
 * + routy k ukládání/vyhodnocení adminských akcí.
 *
 * @package App\Http\Controllers
 */
class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
