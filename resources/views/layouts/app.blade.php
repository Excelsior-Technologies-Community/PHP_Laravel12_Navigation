<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel Navigation App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --bg-color: #f8fafc; --card-bg: #ffffff; --text-color: #374151; --link-color: #6b7280; }
        [data-theme='dark'] { --bg-color: #0f172a; --card-bg: #1e293b; --text-color: #f1f5f9; --link-color: #cbd5e1; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-color); color: var(--text-color); min-height: 100vh; transition: 0.3s; }
        .navbar { background: var(--card-bg); margin: 15px auto; width: 92%; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); padding: 12px 18px; }
        .navbar-brand { font-weight: 700; color: #4f46e5 !important; }
        .nav-link { color: var(--text-color) !important; font-weight: 500; margin: 0 6px; border-radius: 10px; padding: 8px 12px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { background: #4f46e5; color: white !important; }
        .dropdown-menu { background: var(--card-bg); border: none; border-radius: 14px; box-shadow: 0 10px 30px rgba(0,0,0,0.12); padding: 10px; }
        .dropdown-item { color: var(--text-color) !important; border-radius: 10px; padding: 8px 12px; }
        .dropdown-item:hover { background: #4f46e5; color: white !important; }
        .content-card { width: 100%; max-width: 1000px; background: var(--card-bg); border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.1); padding: 30px; animation: fadeIn 0.4s ease-in-out; }
        .breadcrumb-item a { text-decoration: none; color: var(--link-color); }
        .breadcrumb-item.active { color: #4f46e5; font-weight: 600; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        footer { text-align: center; padding: 20px; color: #6b7280; font-size: 14px; }
        .theme-btn { cursor: pointer; border: none; background: #eef2ff; padding: 5px 12px; border-radius: 8px; }
        .offcanvas { background: var(--card-bg); color: var(--text-color); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">⚡ LaravelApp</a>
            <div class="d-flex align-items-center gap-2">
                <button class="theme-btn" onclick="toggleTheme()">🌙/☀️</button>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"><span class="navbar-toggler-icon"></span></button>
            </div>
            <div class="collapse navbar-collapse d-none d-lg-block">
                <ul class="navbar-nav ms-auto">
                    @foreach($menu ?? [] as $item)
                        @if(isset($item['children']))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ $isItemActive($item) ? 'active' : '' }}" data-bs-toggle="dropdown">{{ $item['title'] }}</a>
                                <ul class="dropdown-menu">
                                    @foreach($item['children'] as $child)
                                        <li><a class="dropdown-item {{ request()->routeIs($child['route']) ? 'active' : '' }}" href="{{ route($child['route']) }}">{{ $child['title'] }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item"><a class="nav-link {{ $isItemActive($item) ? 'active' : '' }}" href="{{ route($item['route']) }}">{{ $item['title'] }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-start" id="mobileMenu">
        <div class="offcanvas-header"><h5 class="offcanvas-title">Menu</h5><button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button></div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                @foreach($menu ?? [] as $item)
                    @if(isset($item['children']))
                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ $item['title'] }}</a>
                            <ul class="dropdown-menu">@foreach($item['children'] as $child)<li><a class="dropdown-item" href="{{ route($child['route']) }}">{{ $child['title'] }}</a></li>@endforeach</ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route($item['route']) }}">{{ $item['title'] }}</a></li>
                    @endif
                @endforeach
                <li class="nav-item mt-3"><button class="btn btn-outline-primary w-100" onclick="toggleTheme()">Toggle Theme</button></li>
            </ul>
        </div>
    </div>

    <div class="d-flex flex-column align-items-center min-vh-80 pt-4">
        <div class="container" style="max-width: 1000px; margin-bottom: 20px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    @foreach($breadcrumbs ?? [] as $crumb)
                        <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                            @if(!$loop->last) <a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a> @else {{ $crumb['name'] }} @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
        </div>
        <div class="content-card">@yield('content')</div>
    </div>

    <footer>© {{ date('Y') }} Laravel App • Built with Modern UI ✨</footer>

    <script>
        function toggleTheme() {
            const t = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', t);
            localStorage.setItem('theme', t);
        }
        if(localStorage.getItem('theme') === 'dark') document.documentElement.setAttribute('data-theme', 'dark');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>