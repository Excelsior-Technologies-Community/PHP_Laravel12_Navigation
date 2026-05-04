<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laravel Navigation App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
            min-height: 100vh;
        }

        /* FLOATING NAVBAR */
        .navbar {
            background: white;
            margin: 15px auto;
            width: 92%;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 12px 18px;
        }

        .navbar-brand {
            font-weight: 700;
            color: #4f46e5 !important;
        }

        .nav-link {
            color: #374151 !important;
            font-weight: 500;
            margin: 0 6px;
            border-radius: 10px;
            padding: 8px 12px;
            transition: 0.3s;
        }

        .nav-link:hover {
            background: #eef2ff;
            color: #4f46e5 !important;
        }

        .nav-link.active {
            background: #4f46e5;
            color: white !important;
        }

        /* DROPDOWN */
        .dropdown-menu {
            border: none;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            padding: 10px;
        }

        .dropdown-item {
            border-radius: 10px;
            padding: 8px 12px;
        }

        .dropdown-item:hover {
            background: #4f46e5;
            color: white;
        }

        /* CENTER CARD LAYOUT */
        .main-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding-top: 20px;
        }

        .content-card {
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            padding: 30px;
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* FOOTER */
        footer {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">

        <div class="container-fluid">

            <a class="navbar-brand" href="{{ route('home') }}">
                ⚡ LaravelApp
            </a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="nav">

                <ul class="navbar-nav ms-auto">

                    @foreach($menu ?? [] as $item)

                        @php
                            $isActive = request()->routeIs($item['route']);
                        @endphp

                        @if(isset($item['children']))
                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle {{ $isActive ? 'active' : '' }}" data-bs-toggle="dropdown">
                                    {{ $item['title'] }}
                                </a>

                                <ul class="dropdown-menu">

                                    @foreach($item['children'] as $child)
                                        <li>
                                            <a class="dropdown-item {{ request()->routeIs($child['route']) ? 'active' : '' }}"
                                                href="{{ route($child['route']) }}">
                                                {{ $child['title'] }}
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>

                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ $isActive ? 'active' : '' }}" href="{{ route($item['route']) }}">
                                    {{ $item['title'] }}
                                </a>
                            </li>
                        @endif

                    @endforeach

                </ul>

            </div>
        </div>
    </nav>

    <!-- CENTER CONTENT CARD -->
    <div class="main-wrapper">

        <div class="content-card">

            @yield('content')

        </div>

    </div>

    <!-- FOOTER -->
    <footer>
        © {{ date('Y') }} Laravel App • Built with Modern UI ✨
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>