<?php

namespace App\Http\Controllers\Dashboard;

use App\Facades\UpYeahApi;
use App\Http\Controllers\Controller;
use App\Models\User;

use Inertia\Inertia;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class OverviewController extends Controller
{
    public function index()
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
        try {
            /** @var User */
            $user = Auth::user();

            return UpYeahApi::setToken($user->getToken())->accounts();
        } catch (RequestException $ex) {
            return (object) [];
        }
    }
}
