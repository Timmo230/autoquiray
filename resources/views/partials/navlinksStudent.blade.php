<ul class="navbar-nav align-items-center">
    <li class="nav-item mx-1">
        <a class="nav-link px-3 fw-medium {{ $uri == '/' ? 'active' : '' }}" 
           href="/" 
           id="{{ $uri == '/' ? 'actualPg' : '' }}">
            <i class="fa-solid fa-house-chimney me-1 small opacity-75"></i> Inicio
        </a>
    </li>

    <li class="nav-item mx-1">
        <a class="nav-link px-3 fw-medium {{ $uri == 'tipos_de_test' ? 'active' : '' }}" 
           href="{{ route('student.testType') }}" 
           id="{{ $uri == 'tipos_de_test' ? 'actualPg' : '' }}">
            <i class="fa-solid fa-laptop-code me-1 small opacity-75"></i> Tests Online
        </a>
    </li>

    <li class="nav-item mx-1">
        <a class="nav-link px-3 fw-medium {{ $uri == 'classes' ? 'active' : '' }}" 
           href="{{ route('student.classes') }}" 
           id="{{ $uri == 'classes' ? 'actualPg' : '' }}">
            <i class="fa-solid fa-chalkboard-user me-1 small opacity-75"></i> Mis Clases
        </a>
    </li>

    <li class="nav-item mx-1">
        <a class="nav-link px-3 fw-medium {{ $uri == 'contacto' ? 'active' : '' }}" 
           href="{{ route('student.contacto') }}" 
           id="{{ $uri == 'contacto' ? 'actualPg' : '' }}">
            <i class="fa-solid fa-headset me-1 small opacity-75"></i> Soporte
        </a>
    </li>
</ul>
