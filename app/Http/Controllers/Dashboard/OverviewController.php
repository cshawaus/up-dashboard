<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateAccounts;

use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OverviewController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        if ($request->boolean('updateAccounts', false) === true) {
            UpdateAccounts::dispatchNow($user);
        }

        $user->load([
            'accounts',
            'transactions' => fn ($query) => $query->orderBy('created_at', 'desc')->take(5),
            'transactions.account',
        ]);

        return Inertia::render('Dashboard/Overview', [
            'accounts'     => $user->accounts,
            'transactions' => $user->transactions,
        ]);
    }
}
