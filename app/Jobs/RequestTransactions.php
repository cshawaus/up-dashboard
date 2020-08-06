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

class RequestTransactions implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    private ?string $paginateFrom;
    private User $user;

    public function __construct(User $user, string $paginateFrom = null)
    {
        $this->paginateFrom = $paginateFrom;
        $this->user         = $user;
    }

    public function handle()
    {
        $transactions = UpYeahApi::setToken($this->user->getToken())
            ->transactions(100, $this->paginateFrom);

        if (Arr::exists($transactions, 'data')) {
            $chains = [];

            if ($transactions['links']['next'] !== null) {
                array_push($chains, new RequestTransactions(
                    $this->user,
                    $transactions['links']['next']
                ));
            }

            HandleTransactions::dispatch($this->user, $transactions['data'])->chain($chains);
        }
    }

    public function failed(Exception $exception)
    {
        Log::error('Unable to get transactions!', [
            $this->user->id,
            $exception->getMessage(),
        ]);
    }
}
