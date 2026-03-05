# PHP_Laravel12_Navigation

## Introduction

Introduction

PHP_Laravel12_Navigation is a Laravel 12 project that demonstrates a fully dynamic navigation system using the Spatie Laravel Navigation package.
It allows developers to define menus and submenus in a configuration file and automatically renders them across all Blade views. This project supports multi-level dropdowns, active link highlighting, and is fully customizable using Laravel’s config system.

---

## Project Overview

- Dynamic Navigation: All menus and submenus are generated automatically from a config file.

- Dropdown Support: Nested menus are handled using Spatie’s Section class.

- Automatic Active State: Current page is automatically highlighted.

- Global Blade Availability: Navigation is accessible in all Blade views via a service provider.

- Customizable Layout: Includes modern Bootstrap 5 design with gradient navbar, dropdown animations, and sticky footer.

- Extensible: Additional pages, menu items, or multi-level navigation can easily be added without changing Blade templates.

---

## Features

- Dynamic menus and submenus

- Automatic active state detection

- Global availability in all Blade views

---

## Step 1: Create Laravel 12 Project

```bash
composer create-project laravel/laravel PHP_Laravel12_Navigation "12.*"
cd PHP_Laravel12_Navigation
```

---

## Step 2: Install Spatie Laravel Navigation Package

```bash
composer require spatie/laravel-navigation
```

---

## Step 3: Custom Config 

```bash
php artisan make:config navigation.php
```
Edit: config/navigation.php

```php
<?php

return [
    'items' => [
        [
            'title' => 'Home',
            'route' => 'home',
        ],
        [
            'title' => 'About',
            'route' => 'about',
        ],
        [
            'title' => 'Services',
            'route' => 'services',
            'children' => [
                [
                    'title' => 'Web Development',
                    'route' => 'services.web',
                ],
                [
                    'title' => 'Mobile App',
                    'route' => 'services.mobile',
                ],
            ],
        ],
        [
            'title' => 'Contact',
            'route' => 'contact',
        ],
    ],
];
```

---

## Step 4: Create Navigation Service Provider

```bash
php artisan make:provider NavigationServiceProvider
```

Edit app/Providers/NavigationServiceProvider.php:

```php
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
```

---

## Step 5: Create Blade Layout

resources/views/layouts/app.blade.php

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyApp - Modern Laravel Layout</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, #4f46e5, #3b82f6);
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: 700;
            font-size: 1.6rem;
        }
        .navbar-nav .nav-link {
            color: #e0e7ff !important;
            font-weight: 500;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .navbar-nav .nav-link::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 0%;
            background: linear-gradient(90deg, #facc15, #f59e0b);
            transition: all 0.3s ease;
            border-radius: 3px;
            z-index: -1;
        }
        .navbar-nav .nav-link:hover::after {
            height: 100%;
        }
        .navbar-nav .nav-link.active {
            color: #fff !important;
            font-weight: 700;
        }

        /* Dropdown */
        .dropdown-menu {
            border-radius: 0.5rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }
        .dropdown-item {
            transition: all 0.2s ease;
            border-radius: 0.25rem;
        }
        .dropdown-item:hover, .dropdown-item.active {
            background: linear-gradient(90deg, #facc15, #f59e0b) !important;
            color: #1e40af !important;
            font-weight: 600;
        }

        /* Main Content */
        main.container {
            padding: 2rem 1rem;
            background-color: #fff;
            border-radius: 1rem;
            box-shadow: 0 12px 25px rgba(0,0,0,0.05);
            margin-top: 2rem;
        }

        /* Footer */
        footer {
            background-color: #1e293b;
            color: #cbd5e1;
            padding: 2rem 0;
        }

        /* Navbar toggler */
        .navbar-toggler {
            border-color: rgba(255,255,255,0.3);
        }
        .navbar-toggler-icon {
            filter: invert(1);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top shadow-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">MyApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @foreach(app(Spatie\Navigation\Navigation::class)->tree() as $item)
                    @if(!empty($item['children']))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ ($item['url'] ?? '') === url()->current() ? 'active' : '' }}"
                               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $item['title'] }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach($item['children'] as $child)
                                    <li>
                                        <a class="dropdown-item {{ ($child['url'] ?? '') === url()->current() ? 'active' : '' }}"
                                           href="{{ $child['url'] ?? '#' }}">
                                           {{ $child['title'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ ($item['url'] ?? '') === url()->current() ? 'active' : '' }}"
                               href="{{ $item['url'] ?? '#' }}">
                               {{ $item['title'] }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="container flex-grow-1 mt-5">
    @yield('content')
</main>

<!-- Footer -->
<footer class="mt-auto text-center">
    &copy; {{ date('Y') }} MyApp. All rights reserved.
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

---

## Step 6: Create Page Views

Create the following Blade files inside resources/views/:

### home.blade.php

```blade
@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-4">Home</h1>
<p>Welcome to the Home page!</p>

@endsection
```

### about.blade.php

```blade
@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-4">About</h1>
<p>This is the About page.</p>
@endsection
```

### services.blade.php

```blade
@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-4">Services</h1>
<p>This is the Services page.</p>
@endsection
```

### services-web.blade.php

```blade
@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-4">Web Development</h1>
<p>Web Development Services content here.</p>
@endsection
```

### services-mobile.blade.php

```blade
@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-4">Mobile App</h1>
<p>Mobile App Services content here.</p>
@endsection
```

### contact.blade.php

```blade
@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-4">Contact</h1>
<p>Contact page content goes here.</p>
@endsection
```

---

## Step 7: web.php

```php
<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () { return view('home'); })->name('home');
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/services', function () { return view('services'); })->name('services');
Route::get('/services/web', function () { return view('services-web'); })->name('services.web');
Route::get('/services/mobile', function () { return view('services-mobile'); })->name('services.mobile');
Route::get('/contact', function () { return view('contact'); })->name('contact');
```

---

## Step 8: Run the Project

```bash
php artisan serve
```

Visit: 

```bash
http://127.0.0.1:8000
```

---

## Output

<img width="1919" height="1027" alt="Screenshot 2026-03-05 173652" src="https://github.com/user-attachments/assets/eaed6635-b5a8-4d6c-9270-7cb18e3e704f" />

---

## Project Structure

```
PHP_Laravel12_Navigation/
├── app/
│   └── Providers/
│       └── NavigationServiceProvider.php
├── config/
│   └── navigation.php 
├── resources/
│   └── views/
│       ├── layouts/app.blade.php
│       ├── home.blade.php
│       ├── about.blade.php
│       ├── services.blade.php
│       ├── services-web.blade.php
│       ├── services-mobile.blade.php
│       └── contact.blade.php
├── routes/web.php
├── composer.json
└── README.md
```

---

Your PHP_Laravel12_Navigation Project is now ready!
