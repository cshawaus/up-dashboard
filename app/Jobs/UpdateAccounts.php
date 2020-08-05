<?php

namespace App\Jobs;

use Exception;

use App\Facades\UpYeahApi;
use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateAccounts implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $response = UpYeahApi::setToken($this->user->getToken())->accounts();

        if (!Arr::exists($response, 'data')) {
            throw new Exception('Accounts cannot be updated as the response received is invalid.');
        }

        $accounts = collect($response['data']);

        $accounts->each(function (array $account) {
            $this->user->accounts()->updateOrCreate(
                [
                    'identifier' => $account['id'],
                ],
                [
                    'name'          => $account['attributes']['displayName'],
                    'identifier'    => $account['id'],
                    'created'       => $account['attributes']['createdAt'],
                    'type'          => $account['attributes']['accountType'],
                    'balance'       => floatval($account['attributes']['balance']['value']),
                    'currency_code' => $account['attributes']['balance']['currencyCode'],
                    'created_at'    => Carbon::parse($account['attributes']['createdAt']),
                ]
            );
        });

        // Delete any accounts that no longer exist in the API response
        $this->user->accounts()
            ->whereNotIn('identifier', $accounts->map->id)
            ->delete();
    }

    public function failed(Exception $exception)
    {
        Log::error('Unable to get accounts!', [
            $exception->getMessage(),
            $this->user->id,
        ]);
    }
}
