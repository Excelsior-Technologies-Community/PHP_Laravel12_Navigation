@if(isset($item['children']))
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ $isItemActive($item) ? 'active' : '' }}" data-bs-toggle="dropdown" href="#">
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
        <a class="nav-link {{ $isItemActive($item) ? 'active' : '' }}" href="{{ route($item['route']) }}">
            {{ $item['title'] }}
        </a>
    </li>
@endif