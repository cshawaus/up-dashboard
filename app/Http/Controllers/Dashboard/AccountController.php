<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;

use Inertia\Inertia;

class AccountController extends Controller
{
    public function index(Account $account)
    {
        return Inertia::render('Dashboard/Account', [
            'account'      => $account->withoutRelations(),
            'transactions' => $account->transactions()->getQuery()->paginate(30),
        ]);
    }
}
