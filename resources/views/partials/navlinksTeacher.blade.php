<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link {{ $uri == '/' ? 'active' : '' }}" href="{{ url('/') }}" id="{{ $uri == '/' ? 'actualPg' : '' }}">Inicio</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $uri == 'dashboard' ? 'active' : '' }}" href="{{ route('teacher.dashboard') }}" id="{{ $uri == 'dashboard' ? 'actualPg' : '' }}">Zona Profesores</a>
    </li>
</ul>
