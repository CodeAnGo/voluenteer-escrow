<?php

namespace App\Providers;

use App\Repositories\Interfaces\StripeServiceRepositoryInterface;
use App\Repositories\StripeServiceRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StripeServiceRepositoryInterface::class, StripeServiceRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
