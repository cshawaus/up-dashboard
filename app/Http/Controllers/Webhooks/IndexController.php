<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\User;

use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        /** @var User */
        $user = Auth::user();

        return Inertia::render('Webhooks/Index', [
            'webhooks' => $user->webhooks()->get(),
        ]);
    }
}
