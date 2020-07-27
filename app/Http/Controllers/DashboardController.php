<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $accounts = Cache::remember('up.accounts', now()->addMinutes(10), function () {
            return Http::withToken(env('UP_YEAH_TOKEN'))
                ->get('https://api.up.com.au/api/v1/accounts', [
                    'page[size]' => 10,
                ])
                ->json();
        });

        return Inertia::render('Dashboard/Index', ['accounts' => $accounts])
            ->withViewData(['title' => 'Up Dashboard']);
    }
}
