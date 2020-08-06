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
use Illuminate\Support\Facades\Log;

class RequestTransaction implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    private string $uuid;
    private User $user;

    public function __construct(User $user, string $uuid)
    {
        $this->uuid = $uuid;
        $this->user = $user;
    }

    public function handle()
    {
        $transactions = UpYeahApi::setToken($this->user->getToken())
            ->transactionsById($this->uuid);

        if (Arr::exists($transactions, 'data')) {
            HandleTransactions::dispatch($this->user, [$transactions['data']]);
        }
    }

    public function failed(Exception $exception)
    {
        Log::error('Unable to get transaction!', [
            $this->user->id,
            $this->uuid,
            $exception->getMessage(),
        ]);
    }
}
