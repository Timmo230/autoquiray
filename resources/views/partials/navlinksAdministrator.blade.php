<ul class="navbar-nav align-items-center">
    <li class="nav-item mx-1">
        <a class="nav-link px-3 fw-medium {{ $uri == '/' ? 'active' : '' }}" 
           href="{{ url('/') }}" 
           id="{{ $uri == '/' ? 'actualPg' : '' }}">
            <i class="fa-solid fa-house-chimney me-1 small opacity-75"></i> Inicio
        </a>
    </li>
    <li class="nav-item mx-1">
        <a class="nav-link px-3 fw-medium {{ $uri == 'create_user' ? 'active' : '' }}" 
            href="{{ url('create_user') }}" 
            id="{{ $uri == 'admin.createUser' ? 'actualPg' : '' }}">
                <i class="fa-solid fa-user-plus me-1 small opacity-75"></i> Crear usuario
        </a>
    </li>
    <li class="nav-item mx-1">
        <a class="nav-link px-3 fw-medium {{ $uri == 'admin/dashboard' ? 'active' : '' }}" 
           href="{{ route('admin.dashboard') }}" 
           id="{{ $uri == 'admin/dashboard' ? 'actualPg' : '' }}">
            <i class="fa-solid fa-chart-line me-1 small opacity-75"></i> Panel de Gestión
        </a>
    </li>
</ul>