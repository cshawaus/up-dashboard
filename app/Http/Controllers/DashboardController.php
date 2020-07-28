<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function overview()
    {
        $accounts = Cache::remember('up.accounts', now()->addMinutes(10), function () {
            return Http::withToken(env('UP_YEAH_TOKEN'))
                ->get('https://api.up.com.au/api/v1/accounts')
                ->json();
        });

        return Inertia::render('Dashboard/Overview', ['accounts' => $accounts])
            ->withViewData(['title' => 'Overview']);
    }
}
