<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;

class OverviewController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Overview', [
            'accounts' => Auth::user()->accounts,
        ]);
    }
}
