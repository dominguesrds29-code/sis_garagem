<?php

namespace App\Providers;

use App\Application\ValidateData;
use App\Interfaces\IValidator;
use App\Interfaces\IViaturaRepository;
use App\Repositories\ViaturaRepository;
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
        $this->app->bind(
            IValidator::class,
            ValidateData::class
        );
        $this->app->bind(
            IViaturaRepository::class,
            ViaturaRepository::class
        );
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
