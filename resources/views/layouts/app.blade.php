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