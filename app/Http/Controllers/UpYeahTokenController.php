<?php

namespace App\Http\Controllers;

use Exception;

use App\Facades\UpYeahApi;
use App\Jobs\RequestTransactions;
use App\Jobs\UpdateAccounts;
use App\Models\User;

use Inertia\Inertia;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UpYeahTokenController extends Controller
{
    public function index()
    {
        return Inertia::render('User/SetupToken', ['action' => route('user.set-token-finish')]);
    }

    public function finish(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|starts_with:up:yeah:',
        ]);

        if (!$validator->fails()) {
            try {
                $token = $validator->validated()['token'];

                if ($this->testTokenWithPing($token)) {
                    $user = Auth::user();

                    $this->updateTokenForUser($user, $token);

                    $this->retrieveAccountsAndTransactions($user);
                }

                return Redirect::route('login');
            } catch (Exception $ex) {
                $validator->getMessageBag()->add('generic', 'Your token is invalid or it could not be saved.');

                Log::error('Unable to set up yeah token due to an unexpected failured.', [$ex->getMessage()]);
            }
        }

        return Redirect::route('user.set-token')
            ->withErrors($validator->getMessageBag());
    }

    private function testTokenWithPing(string $token): bool
    {
        try {
            $response = UpYeahApi::setToken($token)->ping();

            if (Arr::exists($response, 'errors')) {
                throw new Exception('Invalid token supplied!');
            }
        } catch (RequestException $ex) {
            throw new Exception('Unable to contact up ping API!');
        }

        return true;
    }

    private function retrieveAccountsAndTransactions(User $user)
    {
        UpdateAccounts::dispatch($user)->chain([
            new RequestTransactions($user),
        ]);
    }

    private function updateTokenForUser(User $user, string $token)
    {
        $user->up_yeah_token = encrypt($token);
        $user->save();
    }
}
