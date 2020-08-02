<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;

use Inertia\Inertia;

class AccountController extends Controller
{
    public function index(Account $account)
    {
        $account->load([
            'transactions' => fn ($query) => $query->orderBy('transactions.created_at', 'asc')->take(10),
            'transactions.account',
        ]);

        return Inertia::render('Dashboard/Account', [
            'account'           => $account->withoutRelations(),
            'transactions'      => $account->transactions,
            'transactionsCount' => $account->transactions()->count(),
        ]);
    }
}
