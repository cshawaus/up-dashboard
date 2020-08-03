<?php

namespace App\Http\Controllers\Dashboard;

use Exception;

use App\Facades\UpYeahApi;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;

use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OverviewController extends Controller
{
    public function index()
    {
        /** @var User */
        $user = Auth::user();

        $user->load([
            'accounts',
            'transactions' => fn ($query) => $query->orderBy('transactions.created_at', 'asc')->take(5),
            'transactions.account',
        ]);

        // TODO: Migrate this process to a job
        if ($user->transactions->count() === 0) {
            UpYeahApi::setToken($user->getToken());

            $this->getTransactions($user);
        }

        return Inertia::render('Dashboard/Overview', [
            'accounts'     => $user->accounts,
            'transactions' => $user->transactions,
        ]);
    }

    private function getTransactions(User $user, Transaction $transaction = null)
    {
        /** @var Transaction|null */
        $lastTransaction = null;

        try {
            $transactions = UpYeahApi::transactions(100, $transaction);

            if (empty($transactions)) {
                return;
            }

            foreach ($transactions['data'] as $transaction) {
                foreach ($user->accounts as $account) {
                    if ($account->identifier !== $transaction['relationships']['account']['data']['id']) {
                        continue;
                    }

                    $lastTransaction = $account->transactions()->create([
                        'description'   => $transaction['attributes']['description'],
                        'message'       => $transaction['attributes']['message'],
                        'identifier'    => $transaction['id'],
                        'created'       => $transaction['attributes']['createdAt'],
                        'settled'       => $transaction['attributes']['settledAt'],
                        'status'        => $transaction['attributes']['status'],
                        'hold_info'     => $transaction['attributes']['holdInfo'],
                        'amount'        => floatval($transaction['attributes']['amount']['value']),
                        'currency_code' => $transaction['attributes']['amount']['currencyCode'],
                        'round_up'      => $transaction['attributes']['roundUp'],
                        'cashback'      => $transaction['attributes']['cashback'],
                    ]);
                }
            }

            if ($transactions['links']['next'] !== null && $lastTransaction !== null) {
                $this->getTransactions($user, $lastTransaction);
            }
        } catch (Exception $ex) {
            Log::error('Unable to get transactions!', [$ex->getMessage()]);
        }
    }
}
