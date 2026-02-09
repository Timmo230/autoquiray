@php
    $type = DB::table('user_is_assigned_types as uat')
        ->join('types as t', 'uat.type_id', '=', 't.id')
        ->where('uat.user_id', auth()->id())
        ->value('t.type');
@endphp
<nav class="navbar navbar-expand-xl bg-navbar position-sticky top-0 z-3 bg-opacity-90" id="nav" data-bs-theme="dark">    
    <div class="container-fluid">

        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="/autoquiray/resources/img/logo/logo.png" width="250" alt="">
        </a>

        <div class="collapse navbar-collapse justify-content-center" id="bigNav">
            @auth
                @if($type === 'administrator')
                    @include('partials.navlinksAdministrator', ['uri' => $uri])
                @elseif($type === 'teacher')
                    @include('partials.navlinksTeacher', ['uri' => $uri])
                @elseif($type === 'student')
                    @include('partials.navlinksStudent', ['uri' => $uri])
                @else
                    @include('partials.navlinksDefault', ['uri' => $uri])
                @endif
            @endauth
            @guest
                @include('partials.navlinksDefault', ['uri' => $uri])
            @endguest
        </div>

        <div class="d-flex align-items-center nav-buttons">
            <button class="navbar-toggler" type="button" type="button" 
                data-bs-toggle="offcanvas" 
                data-bs-target="#smallNav" 
                aria-controls="offcanvasResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="d-none d-xl-flex">
                @auth
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <button type="submit" class="btn btn-green-btn text-white me-3 btngreenLight arriba mt-2 ms-4" style="border: none; background: none; cursor: pointer;">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Cerrar Sesión
                        </button>
                    </form>
                @endauth
                @guest
                    <form action="{{ route('login') }}" method="GET" id="login-form">
                        @csrf
                        <button type="submit" class="btn bg-green-btn text-white me-3 btngreenLight arriba mt-2 ms-4" style="border: none; background: none; cursor: pointer;">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Iniciar sesion
                        </button>
                    </form>
                @endguest
                @auth
                    <div class="nav-link active mx-3 nav-item text-white mt-2 ms-4" id="user">
                        <p class="m-0">{{ auth()->user()->email }}</p>
                        <p class="m-0">{{  $type }}</p>
                    </div>
                @endauth
            </div>
        </div>
    </div>



    <div class="offcanvas-lg offcanvas-end" tabindex="-1" id="smallNav" aria-labelledby="offcanvasResponsiveLabel">
        <div class="offcanvas-header">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="/autoquiray/resources/img/logo/logo.png" width="250" alt="logo" class="ms-4">
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#smallNav" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @auth
                @if($type === 'administrator')
                    @include('partials.navlinksAdministrator', ['uri' => $uri])
                @elseif($type === 'teacher')
                    @include('partials.navlinksTeacher', ['uri' => $uri])
                @elseif($type === 'student')
                    @include('partials.navlinksStudent', ['uri' => $uri])
                @endif
            @endauth
            @guest
                @include('partials.navlinksDefault', ['uri' => $uri])
            @endguest
            <div class="d-flex row">
                @auth
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" class="col-6">
                        @csrf
                        <button type="submit" class="btn btn-green-btn text-white btngreenLight arriba mt-2" style="border: none; background: none; cursor: pointer;">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Cerrar Sesión
                        </button>
                    </form>
                @endauth
                @guest
                    <form action="{{ route('login') }}" method="GET" id="login-form">
                        @csrf
                        <button type="submit" class="btn bg-green-btn text-white btngreenLight arriba mt-2" style="border: none; background: none; cursor: pointer;">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Iniciar sesion
                        </button>
                    </form>
                @endguest
                @auth
                    <div class="nav-link active nav-item text-white mt-3 col" id="user">
                        <p class="m-0">{{ auth()->user()->email }}</p>
                        <p class="m-0">{{ $type }}</p>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>