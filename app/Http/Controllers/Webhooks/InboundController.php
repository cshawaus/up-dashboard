<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Webhook;

use Illuminate\Http\Request;

class InboundController extends Controller
{
    public function receive(User $user, Webhook $webhook, Request $request)
    {
        dd($user, $webhook, $request);
    }
}
