<?php

namespace App\Providers;

use App\Contracts\ProfileRepositoryInterface;
use App\Repositories\ProfileRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProfileRepositoryInterface::class,ProfileRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
