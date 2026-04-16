<ul class="navbar-nav align-items-center">
    <li class="nav-item mx-2">
        <a class="nav-link px-3 fw-medium {{ $uri == '/' ? 'active' : '' }}" 
           href="{{ url('/') }}" 
           id="{{ $uri == '/' ? 'actualPg' : '' }}"
           style="transition: all 0.3s ease;">
            <i class="fa-solid fa-house-chimney me-1 small opacity-75"></i> Inicio
        </a>
    </li>
</ul>
