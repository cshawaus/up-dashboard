<?php

namespace App\Jobs;

use Exception;

use App\Models\Transaction;
use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class HandleTransactions implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    private Collection $accounts;
    private Collection $transactions;
    private User $user;

    public function __construct(User $user, array $transactions)
    {
        $this->accounts     = $user->accounts()->get(['id', 'identifier']);
        $this->transactions = collect($transactions);
        $this->user         = $user;
    }

    public function handle()
    {
        $this->transactions->each(function (array $transaction) {
            $this->createTransaction(
                $transaction['relationships']['account']['data']['id'],
                $transaction
            );
        });
    }

    private function createTransaction(string $accountUUID, array $transaction)
    {
        $createdDate = Carbon::parse($transaction['attributes']['createdAt']);

        $data = [
            'user_id'       => $this->user->id,
            'description'   => $transaction['attributes']['description'],
            'message'       => $transaction['attributes']['message'],
            'raw_text'      => $transaction['attributes']['rawText'],
            'identifier'    => $transaction['id'],
            'created'       => $transaction['attributes']['createdAt'],
            'settled'       => $transaction['attributes']['settledAt'],
            'status'        => $transaction['attributes']['status'],
            'hold_info'     => $transaction['attributes']['holdInfo'],
            'amount'        => floatval($transaction['attributes']['amount']['value']),
            'currency_code' => $transaction['attributes']['amount']['currencyCode'],
            'round_up'      => $transaction['attributes']['roundUp'],
            'cashback'      => $transaction['attributes']['cashback'],
            'created_at'    => $createdDate,
            'updated_at'    => $createdDate,
        ];

        if (is_array($transaction['attributes']['foreignAmount'])) {
            $data['amount_foreign']        = floatval($transaction['attributes']['foreignAmount']['value']);
            $data['currency_code_foreign'] = $transaction['attributes']['foreignAmount']['currencyCode'];
        }

        /** @var \App\Models\Account */
        $account = $this->accounts->firstWhere('identifier', '=', $accountUUID);

        if ($account !== null) {
            $account->transactions()->create($data);
        } else {
            // The account doesn't exist, probably because it was associated with a saver that has since been
            // deleted by the account holder. In that case, just attach the transaction to the to the user in
            // the database so it can be accessed at least.
            $data['account_id'] = null;

            Transaction::create($data);
        }
    }

    public function failed(Exception $exception)
    {
        Log::error('Unable to save transactions!', [
            $this->user->id,
            $exception->getMessage(),
        ]);
    }
}
