@php
    $type = DB::table('user_is_assigned_types as uat')
        ->join('types as t', 'uat.type_id', '=', 't.id')
        ->where('uat.user_id', auth()->id())
        ->value('t.type');
@endphp

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<nav class="navbar navbar-expand-xl fixed-top z-3" id="nav">
    <div class="container-fluid px-md-4">

        <a class="navbar-brand me-4" href="{{ url('/') }}">
            <img src="/resources/img/logo/logo.png"
                 width="220"
                 alt="Autoquiray Logo"
                 class="arriba nav-logo">
        </a>

        <div id="bigNav" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto">
                @auth
                    @if($type === 'administrator') @include('partials.navlinksAdministrator', ['uri' => $uri])
                    @elseif($type === 'teacher') @include('partials.navlinksTeacher', ['uri' => $uri])
                    @elseif($type === 'student') @include('partials.navlinksStudent', ['uri' => $uri])
                    @else @include('partials.navlinksDefault', ['uri' => $uri])
                    @endif
                @endauth
                @guest
                    @include('partials.navlinksDefault', ['uri' => $uri])
                @endguest
            </ul>
        </div>

        <div class="d-flex align-items-center nav-buttons">

            @auth
                <div class="d-none d-xl-block text-end me-4 border-end border-secondary border-opacity-25 pe-4">
                    <p class="m-0 fw-bold text-white small nav-user-email">{{ auth()->user()->email }}</p>
                    <p class="m-0 text-success small fw-bold text-uppercase nav-user-type">{{ $type }}</p>
                </div>

                <div class="d-none d-xl-flex align-items-center">
                    <form action="{{ route('logout') }}" method="POST" class="m-0" data-plausible-submit="logout">
                        @csrf
                        <button type="submit" class="btn btn-success d-flex align-items-center px-3 nav-action-btn">
                            <i class="fa-solid fa-right-from-bracket fs-5"></i>
                        </button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="d-none d-xl-flex align-items-center">
                    <a href="{{ route('login') }}" class="btn btn-success d-flex align-items-center px-4 py-2 nav-action-btn">
                        <i class="fa-solid fa-circle-user me-2"></i> Acceder
                    </a>
                </div>
            @endguest

            <button class="navbar-toggler border-0 ms-3 p-2 nav-toggler"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#smallNav"
                    aria-controls="smallNav">
                <i class="fa-solid fa-bars-staggered text-success fs-1"></i>
            </button>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="smallNav" aria-labelledby="smallNavLabel">

        <div class="offcanvas-header border-bottom border-secondary border-opacity-10">
            <a href="{{ url('/') }}">
                <img src="/resources/img/logo/logo.png" width="160" alt="logo" class="nav-logo-sm">
            </a>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">

            <div class="mobile-nav-links">
                <ul class="navbar-nav w-100">
                    @auth
                        @if($type === 'administrator') @include('partials.navlinksAdministrator', ['uri' => $uri])
                        @elseif($type === 'teacher') @include('partials.navlinksTeacher', ['uri' => $uri])
                        @elseif($type === 'student') @include('partials.navlinksStudent', ['uri' => $uri])
                        @endif
                    @endauth
                    @guest
                        @include('partials.navlinksDefault', ['uri' => $uri])
                    @endguest
                </ul>
            </div>

            <div class="offcanvas-footer-fix mt-auto">
                @auth
                    <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-4 nav-user-card">
                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center nav-user-avatar">
                            <i class="fa-solid fa-user text-dark fs-4"></i>
                        </div>
                        <div class="overflow-hidden">
                            <p class="m-0 text-white small fw-bold text-truncate">{{ auth()->user()->email }}</p>
                            <span class="text-success fw-bold nav-user-type-sm">{{ strtoupper($type) }}</span>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="w-100" data-plausible-submit="logout">
                        @csrf
                        <button type="submit"
                                class="btn btn-outline-danger w-100 rounded-pill py-3 fw-bold border-2 d-flex align-items-center justify-content-center gap-2 nav-logout-btn">
                            <i class="fa-solid fa-right-from-bracket fs-5"></i> Cerrar Sesión
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}"
                       class="btn btn-success w-100 py-3 fw-bold d-flex align-items-center justify-content-center gap-2 nav-login-btn">
                        <i class="fa-solid fa-circle-user fs-5"></i> Iniciar Sesión
                    </a>
                @endguest
            </div>
        </div>
    </div>
</nav>
