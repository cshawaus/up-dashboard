<?php

namespace App\Http\Controllers;

use App\Http\Services\UpYeahApi;
use App\Models\User;

use Inertia\Inertia;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function overview(UpYeahApi $upYeahApi)
    {
        $id = Auth::id();

        $accounts = Cache::remember(
            "up.accounts.$id",
            now()->addMinutes(10),
            fn () => $this->getAccounts($upYeahApi),
        );

        return Inertia::render('Dashboard/Overview', ['accounts' => $accounts]);
    }

    private function getAccounts(UpYeahApi $upYeahApi)
    {
        /** @var User */
        $user = Auth::user();

        try {
            return $upYeahApi->setToken($user->getToken())->accounts();
        } catch (RequestException $ex) {
            return json_encode([]);
        }
    }
}
