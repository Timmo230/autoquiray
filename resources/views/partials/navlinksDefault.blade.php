<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link {{ $uri == '/' ? 'active' : '' }}" href="{{ url('/') }}" id="{{ $uri == '/' ? 'actualPg' : '' }}">Inicio</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $uri == 'contacto' ? 'active' : '' }}" href="{{ route('contacto') }}" id="{{ $uri == 'contacto' ? 'actualPg' : '' }}">Atención al Cliente</a>
    </li>
</ul>
