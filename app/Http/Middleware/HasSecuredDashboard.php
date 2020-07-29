<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\User;

class HasSecuredDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isSetupRoute = $request->is('setup*');
        $secure       = User::all()->count() > 0;

        if (!$secure && !$isSetupRoute) {
            return redirect()->route('setup.index');
        }

        if ($secure && $isSetupRoute) {
            return redirect()->route('dashboard.overview');
        }

        return $next($request);
    }
}
