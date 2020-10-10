<?php

namespace App\Providers;

use App\Exceptions\DenyApiFail;
use Illuminate\Support\ServiceProvider;
use Ubient\PwnedPasswords\Contracts\LookupErrorHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LookupErrorHandler::class, DenyApiFail::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
