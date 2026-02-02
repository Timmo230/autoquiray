<footer class="bg-footer text-light pt-4 px-2 row row-cols-1 justify-content-center">
        <div class="row row-cols-1 row-cols-md-3 mt-2 col footDiv text-center border-bottom border-secondary">
            <div class="col my-1 row row-cols-1">
                <div class="col mb-3">
                    <img src="/autoquiray/resources/img/logo/logo.png" alt="" class="footLogo">
                </div>
                <p class="">Tu autoescuela digital de confianza. Formación de calidad para obtener tu carnet de conducir.</p>
            </div>
            <div class="col d-flex flex-column my-1">
                <p class="fw-bold fs-5">Enlaces Rapidos</p>
                <ul class="navbar-nav mb-2">
                    <li class="nav-item">
                        <a class="nav-link {{ $uri == 'tests' ? 'text-green' : ''}}" href="{{ url('tests') }}">Test Online</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $uri == 'classes' ? 'text-green' : ''}}" href="{{ url('classes') }}">Mis Clases</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $uri == 'contacto' ? 'text-green' : ''}}" href="{{ url('contacto') }}">Contactos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Area Privada</a>
                    </li>
                </ul>
            </div>
            <div class="col d-flex flex-column my-1">
                <p class="fw-bold fs-5">Seguridad</p>
                <ul class="navbar-nav mb-2">
                    <li class="nav-item">
                        <div class="d-flex my-3">
                            <div class="ms-auto">
                                <i class="fa-solid fa-shield-halved text-green mx-2 my-auto fs-5"></i>
                            </div>
                            <div class="me-auto">
                                <p class="opacity-50 my-auto">Datos protegidos RGPD</p>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="d-flex my-3">
                            <div class="ms-auto">
                                <i class="fa-solid fa-lock text-green mx-2 my-auto fs-5"></i>
                            </div>
                            <div class="me-auto">
                                <p class="opacity-50 my-auto">Conexión SSL cifrada</p>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="d-flex my-3">
                            <div class="ms-auto">
                                <i class="fa-solid fa-server text-green mx-2 my-auto fs-5"></i>
                            </div>
                            <div class="me-auto">
                                <p class="opacity-50 my-auto">Servidor local seguro</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div>
            <p class="opacity-50 text-center mt-3">© 2025 AUTOQUIRAY. Todos los derechos reservados. | Aviso Legal | Política de Privacidad</p>
        </div>
    </footer>