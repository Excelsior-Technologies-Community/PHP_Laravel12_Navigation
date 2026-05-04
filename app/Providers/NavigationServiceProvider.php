<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NavigationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        view()->composer('*', function ($view) {

            // SAFE CHECK (prevents null error)
            $menu = config('navigation.items', []);

            $view->with('menu', $menu);
        });
    }
}