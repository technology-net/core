<?php

namespace IBoot\Core\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Get layout
     *
     * @return View
     */
    public function index(): View
    {
        return view('packages/core::dashboard.index');
    }
}
