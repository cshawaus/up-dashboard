<?php

namespace App\Http\Controllers\Dashboard;

use App\Facades\UpYeahApi;
use App\Http\Controllers\Controller;
use App\Models\User;

use Inertia\Inertia;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AccountController extends Controller
{
    public function index(string $uuid)
    {
        $id = Auth::id();

        $meta = Cache::remember(
            "up.account.$uuid.$id",
            now()->addWeek(),
            fn () => $this->getAccountAndTransactions($uuid),
        );

        return Inertia::render('Dashboard/Account', $meta);
    }

    private function getAccountAndTransactions(string $uuid)
    {
        try {
            /** @var User */
            $user = Auth::user();

            return [
                'account'      => UpYeahApi::setToken($user->getToken())->account($uuid),
                'transactions' => UpYeahApi::setToken($user->getToken())->transactionsByAccount($uuid),
            ];
        } catch (RequestException $ex) {
            return (object) [];
        }
    }
}
