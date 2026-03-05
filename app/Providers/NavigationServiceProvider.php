<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Navigation\Navigation;
use Spatie\Navigation\Section;

class NavigationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Load menu from config/navigation.php
        $this->app->resolving(Navigation::class, function (Navigation $navigation) {

            $menuItems = config('navigation.items', []);

            foreach ($menuItems as $item) {
                // Check if the item has children
                if (isset($item['children'])) {
                    $navigation->add($item['title'], route($item['route']), function (Section $section) use ($item) {
                        foreach ($item['children'] as $child) {
                            $section->add($child['title'], route($child['route']));
                        }
                    });
                } else {
                    $navigation->add($item['title'], route($item['route']));
                }
            }

        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
        $view->with('menu', $this->app->make(Navigation::class));
    });
    }
}