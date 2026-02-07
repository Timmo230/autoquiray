<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link {{ $uri == '/' ? 'active' : '' }}" href="{{ url('/') }}" id="{{ $uri == '/' ? 'actualPg' : '' }}">Inicio</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $uri == 'test' ? 'active' : '' }}" href="{{ route('student.testType') }}" id="{{ $uri == 'test' ? 'actualPg' : '' }}">Tests Online</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $uri == 'classes' ? 'active' : '' }}" href="{{ route('student.classes') }}" id="{{ $uri == 'classes' ? 'actualPg' : '' }}">Mis Clases</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $uri == 'contacto' ? 'active' : '' }}" href="{{ route('student.contacto') }}" id="{{ $uri == 'contacto' ? 'actualPg' : '' }}">Atención al Cliente</a>
    </li>
</ul>