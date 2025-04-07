<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (!haveAccessTo('view_dashboard')) {
            return redirect()->back();
        }

        return view('pages.admin.dashboard');
    }
}
