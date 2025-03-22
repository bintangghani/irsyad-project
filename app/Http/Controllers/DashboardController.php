<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (!haveAccessTo('view_dashboard')) {
            abort(403);
        }

        return view('pages.admin.dashboard');
    }
}
