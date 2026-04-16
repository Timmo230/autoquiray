@php
    $type = DB::table('user_is_assigned_types as uat')
        ->join('types as t', 'uat.type_id', '=', 't.id')
        ->where('uat.user_id', auth()->id())
        ->value('t.type');
@endphp

<footer class="pt-5 px-2">
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-3 mt-2 footDiv text-center border-bottom border-secondary border-opacity-25 pb-4">
            
            <div class="col my-3 d-flex flex-column align-items-center">
                <div class="mb-4">
                    <img src="/resources/img/logo/logo.png" alt="Autoquiray Logo" class="footLogo">
                </div>
                <p class="px-4 text-grey small">
                    Tu autoescuela digital de confianza. <br>
                    Formación de alta tecnología para obtener tu carnet de conducir.
                </p>
            </div>

            <div class="col d-flex flex-column my-3">
                <p class="text-white fw-bold fs-5 mb-3">Enlaces Rápidos</p>
                <ul class="navbar-nav mb-2">
                    @auth
                        @if($type == 'student')
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'tipos_de_test' ? 'text-green-btn' : ''}}" 
                                href="{{ route('student.testType') }}">Test Online</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'classes' ? 'text-green-btn' : ''}}" 
                                href="{{ route('student.classes') }}">Mis Clases</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'contacto' ? 'text-green-btn' : ''}}" 
                                href="{{ route('student.contacto') }}">Contactos</a>
                            </li>
                        @elseif($type == 'teacher')
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'teacher/dashboard' ? 'text-green-btn' : ''}}" 
                                href="{{ route('teacher.dashboard') }}">Información alumnos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'crear_tests' ? 'text-green-btn' : ''}}" 
                                href="{{ route('teacher.createTests') }}">Crear tests</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'create_classes' ? 'text-green-btn' : ''}}" 
                                href="{{ route('teacher.createClasses') }}">Crear tests</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'admin/dashboard' ? 'text-green-btn' : ''}}" 
                                href="{{ route('admin.dashboard') }}">Informacion profesores</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'create_user' ? 'text-green-btn' : ''}}" 
                                href="{{ route('admin.createUser') }}">Crear usuario</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'create_timetable' ? 'text-green-btn' : ''}}" 
                                href="{{ route('admin.createTimetable') }}">Crear horario</a>
                            </li>
                        @endif
                    @endauth
                    
                    @guest
                        <li class="nav-item">
                            <a class="nav-link {{ $uri == 'contacto' ? 'text-green-btn' : ''}}" 
                            href="{{ route('student.contacto') }}">Contactos</a>
                        </li>
                    @endguest
                </ul>
            </div>

            <div class="col d-flex flex-column my-3">
                <p class="text-white fw-bold fs-5 mb-3">Seguridad</p>
                <ul class="navbar-nav mb-2">
                    <li class="nav-item mb-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-shield-halved text-green-btn me-3 fs-5"></i>
                            <p class="text-grey m-0 small">Datos protegidos RGPD</p>
                        </div>
                    </li>
                    <li class="nav-item mb-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-lock text-green-btn me-3 fs-5"></i>
                            <p class="text-grey m-0 small">Conexión SSL cifrada</p>
                        </div>
                    </li>
                    <li class="nav-item mb-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-server text-green-btn me-3 fs-5"></i>
                            <p class="text-grey m-0 small">Servidor local seguro</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12 py-4">
                <p class="text-grey text-center m-0 small">
                    © 2026 <span class="text-green-btn fw-bold">AUTOQUIRAY</span>. Todos los derechos reservados. | 
                    <a href="#" class="text-grey text-decoration-none mx-1">Aviso Legal</a> | 
                    <a href="#" class="text-grey text-decoration-none mx-1">Privacidad</a>
                </p>
            </div>
        </div>
    </div>
</footer>