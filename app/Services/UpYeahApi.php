<?php

namespace App\Services;

use Exception;

use App\Models\Transaction;

use Whoops\Exception\ErrorException;

use Illuminate\Http\Client\PendingRequest as Http;

class UpYeahApi extends Http
{
    /**
     * The base URL for the request.
     *
     * @var string
     */
    protected $baseUrl = 'https://api.up.com.au/api/v1';

    /**
     * Tracks the number of requests left for the token.
     */
    private ?int $requestLimit = null;

    /**
     * Token needed to make API requests to up.
     */
    private ?string $token = null;

    /**
     * Send a request to the Up Yeah API.
     *
     * @param  string  $url
     * @param  array  $params
     * @return mixed
     */
    private function makeRequest(string $url, array $params = [])
    {
        if ($this->token === null) {
            throw new ErrorException('The token provided cannot be used as it is invalid, please set a valid token.');
        }

        if ($this->requestLimit === 0) {
            throw new ErrorException('Unable to make request as the rate limit has been reached.');
        }

        $request = $this->withToken($this->token)->get($url, $params);

        $this->requestLimit = intval($request->headers()['X-RateLimit-Remaining']);

        if ($request->successful() || $request->clientError()) {
            return $request->json();
        }

        $request->throw();
    }

    /**
     * Generate a base set of parameters for every request.
     */
    private function generateParams(int $pageSize): array
    {
        return [
            'page[size]' => $pageSize,
        ];
    }

    /**
     * Set the API token.
     */
    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Check the health of the token to ensure that it is valid.
     *
     * @see https://developer.up.com.au/#get_util_ping
     */
    public function ping()
    {
        return $this->makeRequest('/util/ping');
    }

    /**
     * Find and retrieve all of the accounts associated with the token.
     *
     * @see https://developer.up.com.au/#get_accounts
     */
    public function accounts()
    {
        return $this->makeRequest('/accounts');
    }

    /**
     * Retrieve the account for the given UUID.
     *
     * @see https://developer.up.com.au/#get_accounts_id
     */
    public function account(string $uuid)
    {
        return $this->makeRequest(sprintf('/accounts/%s', $uuid));
    }

    /**
     * Retrieve all transactions for entire up account.
     *
     * @see https://developer.up.com.au/#get_transactions
     */
    public function transactions(int $pageSize = 100, Transaction $paginateFrom = null)
    {
        $params = $this->generateParams($pageSize);

        if ($paginateFrom !== null) {
            if ($paginateFrom->exists === false) {
                throw new Exception('Pagination could not be constructed as the transaction model is invalid.');
            }

            $params['page[after]'] = base64_encode(sprintf(
                '["%s","%s"]',
                $paginateFrom->created,
                $paginateFrom->identifier,
            ));
        }

        return $this->makeRequest('/transactions', $params);
    }

    /**
     * Retrieve the transaction for the given UUID.
     *
     * @see https://developer.up.com.au/#get_transactions_id
     */
    public function transactionsById(string $uuid)
    {
        return $this->makeRequest(sprintf('/transactions/%s', $uuid));
    }

    /**
     * Retrieve the account transactions for the given UUID.
     *
     * @see https://developer.up.com.au/#get_accounts_accountId_transactions
     */
    public function transactionsByAccount(string $uuid, int $pageSize = 100, Transaction $paginateFrom = null)
    {
        $params = $this->generateParams($pageSize);

        if ($paginateFrom !== null) {
            if ($paginateFrom->exists === false) {
                throw new Exception('Pagination could not be constructed as the transaction model is invalid.');
            }

            $params['page[after]'] = base64_encode(sprintf(
                '["%s","%s"]',
                $paginateFrom->created,
                $paginateFrom->identifier,
            ));
        }

        return $this->makeRequest(sprintf('/accounts/%s/transactions', $uuid), $params);
    }
}
