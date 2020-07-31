<?php

namespace App\Services;

use Whoops\Exception\ErrorException;

use Illuminate\Http\Client\PendingRequest as Http;

class UpYeahApi extends Http
{
    /**
     * The base URL for the request.
     *
     * @var string
     */
    protected $baseUrl = 'https://api.up.com.au/api/v1/';

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
     * @param  string  $uri
     * @return mixed
     */
    private function makeRequest(string $uri)
    {
        if ($this->token === null) {
            throw new ErrorException('The token provided cannot be used as it is invalid, please set a valid token.');
        }

        if ($this->requestLimit === 0) {
            throw new ErrorException('Unable to make request as the rate limit has been reached.');
        }

        $request = $this->withToken($this->token)->get($uri);

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
     * Check the health of the token to ensure that it is valid.
     */
    public function ping()
    {
        return $this->makeRequest('util/ping');
    }

    /**
     * Find and retrieve all of the accounts associated with the token.
     */
    public function accounts()
    {
        return $this->makeRequest('accounts');
    }
}
