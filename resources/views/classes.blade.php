@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Clases</title>
    @include("partials.links")
    <link rel="stylesheet" href="./statics/css/classes.css">
</head>
<body class="bg-main">
    @include("partials.nav", ["uri" => $uri])

    <main class="container-fluid mb-5">
        <article>
            <section class="row row-cols-1 row-cols-md-2 align-items-center mb-4">
                <div class="col px-5">
                    <h3 class="h-50 rubik pt-2 fs-2">Mis clases</h3>
                    <p class="rubik pt-2 fs-5-5">Gestiona tus clases practicas  de conduccion</p>
                </div>
                <div class="col px-5 d-flex">
                    <button type="button" 
                        class="btn arriba btngreenLight bg-green-btn text-white fs-5 ms-auto"
                        data-bs-toggle="modal"
                        data-bs-target="#reserves">
                        <i class="fa-solid fa-plus fs-5 pe-2"></i>Reservar Clase
                    </button>
                </div>
            </section>
            <section class="px-5 mb-4">
                <div class="d-flex align-items-center">
                    <i class="fa-regular fa-calendar fs-5 text-green-btn me-2"></i>
                    <h3 class="h-50 rubik pt-2 fs-3">Proximas clases</h3>
                </div>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                    <div class="col p-2">
                        <div class="card rounded-4 green">
                            <div class="card-body">
                                <span class="badge rounded-pill bg-green-btn text-light bg-opacity-75 my-1">Confirmada</span>
                                <h5 class="card-title">Clase Practica #12</h5>
                                <p class="card-text">Maniobras en rotondas</p>
                                <div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fa-regular fa-calendar text-secondary"></i>
                                        <p class="my-auto mx-2 opacity-75">Mañana</p>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fa-regular fa-clock"></i>
                                        <p class="my-auto mx-2 opacity-75">10:00 - 11:00</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex">
                                    <img src="" alt="" class="rounded-50">
                                    <p class="my-auto mx-2 opacity-75">Prof. Juan Martinez</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col p-2">
                        <div class="card rounded-4 yellow">
                            <div class="card-body">
                                <span class="badge rounded-pill bg-yellow text-light bg-opacity-75 my-1">Confirmada</span>
                                <h5 class="card-title">Clase Practica #12</h5>
                                <p class="card-text">Maniobras en rotondas</p>
                                <div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fa-regular fa-calendar text-secondary"></i>
                                        <p class="my-auto mx-2 opacity-75">Mañana</p>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fa-regular fa-clock"></i>
                                        <p class="my-auto mx-2 opacity-75">10:00 - 11:00</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex">
                                    <img src="" alt="" class="rounded-50">
                                    <p class="my-auto mx-2 opacity-75">Prof. Juan Martinez</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col p-2">
                        <div class="card rounded-4 green">
                            <div class="card-body">
                                <span class="badge rounded-pill bg-green-btn text-light bg-opacity-75 my-1">Confirmada</span>
                                <h5 class="card-title">Clase Practica #12</h5>
                                <p class="card-text">Maniobras en rotondas</p>
                                <div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fa-regular fa-calendar text-secondary"></i>
                                        <p class="my-auto mx-2 opacity-75">Mañana</p>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fa-regular fa-clock"></i>
                                        <p class="my-auto mx-2 opacity-75">10:00 - 11:00</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex">
                                    <img src="" alt="" class="rounded-50">
                                    <p class="my-auto mx-2 opacity-75">Prof. Juan Martinez</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="">
                <div class="d-flex align-items-center px-5">
                    <i class="fa-regular fa-clock fs-5 me-2"></i>
                    <h3 class="h-50 rubik pt-2 fs-3">Clases Pasadas</h3>
                </div>
                <div class="container-fluid my-4">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body p-0 table-responsive">
                            <table class="table mb-0 align-middle table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 opacity-50">Clase</th>
                                        <th class="opacity-50">Fecha</th>
                                        <th class="opacity-50">Profesor</th>
                                        <th class="pe-4 opacity-50">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-semibold">Clase #11</div>
                                            <small class="text-muted">Aparcamiento en batería</small>
                                        </td>
                                        <td>12/01/2025</td>
                                        <td>Juan Martínez</td>
                                        <td class="pe-4">
                                            <span class="badge rounded-pill bg-green-btn text-white px-3 py-2">
                                                Completada
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-semibold">Clase #10</div>
                                            <small class="text-muted">Conducción urbana</small>
                                        </td>
                                        <td>10/01/2025</td>
                                        <td>Ana López</td>
                                        <td class="pe-4">
                                            <span class="badge rounded-pill bg-green-btn text-white px-3 py-2">
                                                Completada
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-semibold">Clase #9</div>
                                            <small class="text-muted">Cambio de marchas</small>
                                        </td>
                                        <td>08/01/2025</td>
                                        <td>Juan Martínez</td>
                                        <td class="pe-4">
                                            <span class="badge rounded-pill bg-green-btn text-white px-3 py-2">
                                                Completada
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </article>
    </main>

    <div class="modal fade" id="reserves" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true">
        
    <div class="modal-dialog modal-dialog-centered">
        <form action="#">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalCenterTitle">Reservar Clase</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <p class="fs-5-5">Fecha</p>
                        <div class="input-group mb-3">
                            <select class="form-select" id="selectDate">
                                <option selected>dd/mm/yyyy</option>
                                <option value="18/5/26">18/5/26</option>
                                <option value="19/5/26">19/5/26</option>
                                <option value="20/5/26">20/5/26</option>
                            </select>
                            <label class="input-group-text" for="inputGroupSelect02"><i class="fa-regular fa-calendar"></i></label>
                        </div>
                    </div>
                    <div>
                        <p class="fs-5-5">Hora</p>
                        <select class="form-select form-select-lg mb-3" aria-label="Large select example">
                            <option selected>Elije la hora</option>
                            <option value="1">11:30 - 12:30</option>
                            <option value="2">12:30 - 13:30</option>
                            <option value="3">13:30 - 14:30</option>
                        </select>
                    </div>
                    <div>
                        <p class="fs-5-5">Profesor</p>
                        <select class="form-select form-select-lg mb-3" aria-label="Large select example">
                            <option selected>Selecciona el profesor</option>
                            <option value="1">Juan Martinez</option>
                            <option value="2">Yeray Sampalo</option>
                            <option value="3">Sidelly Ciruela</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer p-4">
                    <button type="submit" class="btn btn-green-btn btngreenLight arriba text-white w-100 fs-5">Confirmar reserva</button>
                </div>
                </div>
            </div>
        </form>
    </div>

    @include("partials.footer")
    @include("partials.scripts")
</body>
</html>