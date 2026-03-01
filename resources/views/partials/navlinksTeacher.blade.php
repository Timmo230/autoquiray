<ul class="navbar-nav align-items-center">
    <li class="nav-item mx-1">
        <a class="nav-link px-3 fw-medium {{ $uri == '/' ? 'active' : '' }}" 
           href="{{ url('/') }}" 
           id="{{ $uri == '/' ? 'actualPg' : '' }}">
            <i class="fa-solid fa-house-chimney me-1 small opacity-75"></i> Inicio
        </a>
    </li>

    <li class="nav-item mx-1">
        <a class="nav-link px-3 fw-medium {{ $uri == 'dashboard' ? 'active' : '' }}" 
           href="{{ route('teacher.dashboard') }}" 
           id="{{ $uri == 'dashboard' ? 'actualPg' : '' }}">
            <i class="fa-solid fa-chart-line me-1 small opacity-75"></i> Panel de Gestión
        </a>
    </li>
    
    <li class="nav-item mx-1">
        <a class="nav-link px-3 fw-medium {{ $uri == 'create_tests' ? 'active' : '' }}" 
           href="{{ url('crear_tests') }}" 
           id="{{ $uri == 'crear_tests' ? 'actualPg' : '' }}">
            <i class="fa-solid fa-plus-circle me-1 small opacity-75"></i> Crear Test
        </a>
    </li>
</ul>