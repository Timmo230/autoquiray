<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link {{ $uri == '/' ? 'active' : '' }}" href="{{ url('/') }}" id="{{ $uri == '/' ? 'actualPg' : '' }}">Inicio</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $uri == 'tests' ? 'active' : '' }}" href="{{ url('/tests') }}" id="{{ $uri == 'tests' ? 'actualPg' : '' }}">Tests Online</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $uri == 'classes' ? 'active' : '' }}" href="{{ url('/classes') }}" id="{{ $uri == 'classes' ? 'actualPg' : '' }}">Mis Clases</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $uri == 'contacto' ? 'active' : '' }}" href="{{ url('/contacto') }}" id="{{ $uri == 'contacto' ? 'actualPg' : '' }}">Atención al Cliente</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $uri == 'teacher/dashboard' ? 'active' : '' }}" href="{{ url('/teacher/dashboard') }}" id="{{ $uri == 'teacher/dashboard' ? 'actualPg' : '' }}">Zona Profesores</a>
    </li>
</ul>
