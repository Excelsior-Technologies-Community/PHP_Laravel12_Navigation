<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Request;

class NavigationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $menu = config('navigation.items', []);
            $currentPath = Request::path();

            $isItemActive = function ($item) {
                if (request()->routeIs($item['route'])) return true;
                if (isset($item['children'])) {
                    foreach ($item['children'] as $child) {
                        if (request()->routeIs($child['route'])) return true;
                    }
                }
                return false;
            };

            // Breadcrumbs Logic
            $segments = explode('/', $currentPath);
            $breadcrumbs = [];
            $url = '';
            foreach ($segments as $segment) {
                if ($segment == 'index' || $segment == '/') continue;
                $url .= '/' . $segment;
                $breadcrumbs[] = ['name' => ucfirst($segment), 'url' => $url];
            }

            $view->with([
                'menu' => $menu,
                'isItemActive' => $isItemActive,
                'breadcrumbs' => $breadcrumbs
            ]);
        });
    }
}