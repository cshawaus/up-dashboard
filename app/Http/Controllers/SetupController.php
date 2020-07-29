<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Http\Request;

class SetupController extends Controller
{
    public function index()
    {
        return Inertia::render('Setup/Index', ['action' => route('setup.index')]);
    }

    public function finish(Request $request)
    {
        dd($request);
    }
}
