@php
    $type = DB::table('user_is_assigned_types as uat')
        ->join('types as t', 'uat.type_id', '=', 't.id')
        ->where('uat.user_id', auth()->id())
        ->value('t.type');
@endphp

<footer class="bg-footer text-light pt-4 px-2 overflow-hidden">
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-3 mt-2 footDiv text-center border-bottom border-secondary pb-3">
            
            <div class="col my-1 d-flex flex-column align-items-center">
                <div class="mb-3">
                    <img src="/autoquiray/resources/img/logo/logo.png" alt="Autoquiray Logo" class="footLogo">
                </div>
                <p class="px-3">Tu autoescuela digital de confianza. Formación de calidad para obtener tu carnet de conducir.</p>
            </div>

            <div class="col d-flex flex-column my-1">
                <p class="fw-bold fs-5">Enlaces Rápidos</p>
                <ul class="navbar-nav mb-2">
                    @auth
                        @if($type == 'student')
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'tipos_de_test' ? 'text-green' : ''}}" href="{{ url('tipos_de_test') }}">Test Online</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'classes' ? 'text-green' : ''}}" href="{{ url('classes') }}">Mis Clases</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'contacto' ? 'text-green' : ''}}" href="{{ url('contacto') }}">Contactos</a>
                            </li>
                        @elseif($type == 'teacher')
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'dashboard' ? 'text-green' : ''}}" href="{{ url('dashboard') }}">Información alumnos</a>
                            </li>
                        @endif
                    @endauth
                    
                    @guest
                        <li class="nav-item">
                            <a class="nav-link {{ $uri == 'contacto' ? 'text-green' : ''}}" href="{{ url('contacto') }}">Contactos</a>
                        </li>
                    @endguest
                </ul>
            </div>

            <div class="col d-flex flex-column my-1">
                <p class="fw-bold fs-5">Seguridad</p>
                <ul class="navbar-nav mb-2">
                    <li class="nav-item mb-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-shield-halved text-green me-2 fs-5"></i>
                            <p class="opacity-50 m-0">Datos protegidos RGPD</p>
                        </div>
                    </li>
                    <li class="nav-item mb-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-lock text-green me-2 fs-5"></i>
                            <p class="opacity-50 m-0">Conexión SSL cifrada</p>
                        </div>
                    </li>
                    <li class="nav-item mb-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-server text-green me-2 fs-5"></i>
                            <p class="opacity-50 m-0">Servidor local seguro</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <p class="opacity-50 text-center mt-3 small">
                    © 2025 AUTOQUIRAY. Todos los derechos reservados. | Aviso Legal | Política de Privacidad
                </p>
            </div>
        </div>
    </div>
</footer>