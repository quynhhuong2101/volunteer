<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Laravel Boost MCP Server
        if (class_exists(\Laravel\Boost\Mcp\Boost::class) && class_exists(\Laravel\Mcp\Facades\Mcp::class)) {
            \Laravel\Mcp\Facades\Mcp::local('laravel-boost', \Laravel\Boost\Mcp\Boost::class);
        }
        
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);
    }
}
