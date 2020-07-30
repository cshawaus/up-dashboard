<?php

namespace App\Http\Services;

use Whoops\Exception\ErrorException;

use Illuminate\Support\Facades\Http;

class UpYeahApi
{
    private static string $API_URL = 'https://api.up.com.au/api/v1/';

    /**
     * Tracks the number of requests left for the token.
     */
    private ?int $requestLimit = null;

    /**
     * Token needed to make API requests to up.
     */
    private string $token;

    private function makeRequest(string $uri)
    {
        if ($this->requestLimit === 0) {
            throw new ErrorException('Unable to make request as the rate limit has been reached.');
        }

        $request = Http::withToken($this->token)->get(static::$API_URL . $uri);

        $this->requestLimit = intval($request->headers()['X-RateLimit-Remaining']);

        if ($request->successful() || $request->clientError()) {
            return $request->json();
        }

        $request->throw();
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
     * Ping the API to check the token is working correctly.
     */
    public function ping()
    {
        return $this->makeRequest('util/ping');
    }

    /**
     * Retrieve all the accounts.
     */
    public function accounts()
    {
        return $this->makeRequest('accounts');
    }
}
