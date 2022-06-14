<?php

namespace App\Providers;

use App\Application\ValidateData;
use App\Interfaces\IDefaultRepository;
use App\Interfaces\IMotoristaRepository;
use App\Interfaces\IUserRepository;
use App\Interfaces\IValidator;
use App\Interfaces\IViaturaRepository;
use App\Repositories\DefaultRepository;
use App\Repositories\MotoristaRepository;
use App\Repositories\UserRepository;
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
            IDefaultRepository::class,
            DefaultRepository::class
        );
        $this->app->bind(
            IViaturaRepository::class,
            ViaturaRepository::class
        );
        $this->app->bind(
            IMotoristaRepository::class,
            MotoristaRepository::class
        );
        $this->app->bind(
            IUserRepository::class,
            UserRepository::class
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
