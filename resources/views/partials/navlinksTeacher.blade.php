<ul class="navbar-nav align-items-center">
    <li class="nav-item mx-1">
        <a class="nav-link px-3 fw-medium {{ $uri == '/' ? 'active' : '' }}" 
           href="{{ url('/') }}" 
           id="{{ $uri == '/' ? 'actualPg' : '' }}">
            <i class="fa-solid fa-house-chimney me-1 small opacity-75"></i> Inicio
        </a>
    </li>

    <li class="nav-item mx-1">
        <a class="nav-link px-3 fw-medium {{ $uri == 'teacher/dashboard' ? 'active' : '' }}" 
           href="{{ route('teacher.dashboard') }}" 
           id="{{ $uri == 'teacher/dashboard' ? 'actualPg' : '' }}">
            <i class="fa-solid fa-chart-line me-1 small opacity-75"></i> Panel de Gestión
        </a>
    </li>
    
    <li class="nav-item mx-1">
        <a class="nav-link px-3 fw-medium {{ $uri == 'create_tests' ? 'active' : '' }}" 
           href="{{ route('teacher.createTests') }}" 
           id="{{ $uri == 'crear_tests' ? 'actualPg' : '' }}">
            <i class="fa-solid fa-plus-circle me-1 small opacity-75"></i> Crear Test
        </a>
    </li>

    <li class="nav-item mx-1">
        <a class="nav-link px-3 fw-medium {{ $uri == 'create_classes' ? 'active' : '' }}" 
           href="{{ route('teacher.createClasses') }}" 
           id="{{ $uri == 'create_classes' ? 'actualPg' : '' }}">
            <i class="fa-solid fa-chalkboard-user me-1 small opacity-75"></i> Crear classes
        </a>
    </li>
</ul>