<?php

namespace App\Http\Controllers;

use App\Facades\UpYeahApi;
use App\Models\User;

use Inertia\Inertia;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function overview()
    {
        $id = Auth::id();

        $accounts = Cache::remember(
            "up.accounts.$id",
            now()->addWeek(),
            fn () => $this->getAccounts(),
        );

        return Inertia::render('Dashboard/Overview', ['accounts' => $accounts]);
    }

    private function getAccounts()
    {
        /** @var User */
        $user = Auth::user();

        try {
            return UpYeahApi::setToken($user->getToken())->accounts();
        } catch (RequestException $ex) {
            return json_encode([]);
        }
    }
}
