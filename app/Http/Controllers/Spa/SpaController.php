<?php

namespace App\Http\Controllers\Spa;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Class SpaController
 *
 * Single page Vue.js app controller.
 *
 * @package App\Http\Controllers\Spa
 */
class SpaController extends Controller
{
    /**
     * Render single page app.
     *
     * @return Application|Factory|View
     */
    public function spa()
    {
        return view('spa', []);
    }
}
