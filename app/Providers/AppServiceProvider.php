<?php

namespace App\Providers;

use App\Http\Services\UpYeahApi;

use Inertia\Inertia;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UpYeahApi::class, fn () => new UpYeahApi);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Inertia::share([
            'app.name' => config('app.name'),
            'app.url'  => asset('/'),

            'errors' => fn () => Session::get('errors')
                ? Session::get('errors')->getBag('default')->getMessages()
                : (object) [],
        ]);

        Inertia::setRootView('layouts.inertia');

        Inertia::version(fn () => md5_file(public_path('mix-manifest.json')));
    }
}
