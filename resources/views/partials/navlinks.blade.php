@php
    $uri = request()->path(); // devuelve algo como '' para home, 'tests', 'classes', etc.
@endphp

<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link {{ $uri == '/' ? 'active' : '' }}" href="{{ url('/') }}" id="actualPg">Inicio</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $uri == 'tests' ? 'active' : '' }}" href="{{ url('/tests') }}" id="actualPg">Tests Online</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $uri == 'classes' ? 'active' : '' }}" href="{{ url('/classes') }}" id="actualPg">Mis Clases</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $uri == 'contacto' ? 'active' : '' }}" href="{{ url('/contacto') }}" id="actualPg">Atención al Cliente</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $uri == 'zona-profesores' ? 'active' : '' }}" href="{{ url('/zona-profesores') }}" id="actualPg">Zona Profesores</a>
    </li>
</ul>
