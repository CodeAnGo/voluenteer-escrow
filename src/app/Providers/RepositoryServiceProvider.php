<?php

namespace App\Providers;

use App\Repositories\AddressRepository;
use App\Repositories\CharityRepository;
use App\Repositories\Interfaces\AddressRepositoryInterface;
use App\Repositories\Interfaces\CharityRepositoryInterface;
use App\Repositories\Interfaces\StripeServiceRepositoryInterface;
use App\Repositories\Interfaces\TransferRepositoryInterface;
use App\Repositories\StripeServiceRepository;
use App\Repositories\TransferRepository;
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
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
        $this->app->bind(CharityRepositoryInterface::class, CharityRepository::class);
        $this->app->bind(TransferRepositoryInterface::class, TransferRepository::class);
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
