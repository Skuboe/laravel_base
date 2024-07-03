<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Services\ConfigService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->singleton('SecureUtilFacade', 'App\Common\SecureUtil');
        app()->singleton('DateUtilFacade', 'App\Common\DateUtil');
        app()->singleton('StringUtilFacade', 'App\Common\StringUtil');
        app()->singleton('CheckUtilFacade', 'App\Common\CheckUtil');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
