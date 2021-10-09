<?php

namespace App\Providers;

use App\Http\Controllers\Api\NewsController;
use App\Services\ICrudService;
use App\Services\News\NewsService;
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
        $this->app
            ->when(NewsController::class)
            ->needs(ICrudService::class)
            ->give(NewsService::class);
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
