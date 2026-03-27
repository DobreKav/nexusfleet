<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Redirect drivers to their dashboard
        if ($user->isDriver()) {
            return redirect()->route('driver.dashboard');
        }

        return view('dashboard');
    }
}
