<?php

namespace App\Providers;

use App\Modules\Todo\Repositories\TodoRepository;
use App\Modules\Todo\Services\TodoService;
use App\Modules\Token\Services\TokenService;
use Illuminate\Support\ServiceProvider;

class BackendTestServiceProvider extends ServiceProvider
{
    public $singletons = [
        TokenService::class => TokenService::class,
        TodoRepository::class => TodoRepository::class,
        TodoService::class => TodoService::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
