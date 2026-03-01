@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Clases</title>

    @include("partials.links")
    <link rel="stylesheet" href="/autoquiray/resources/css/classes.css">
</head>

<body class="bg-main">
    @include("partials.nav", ["uri" => $uri])

    <main class="container-fluid main-spacing mb-5">
        <article>

            {{-- HEADER SIN BOTÓN GRANDE --}}
            <section class="px-5 mb-4">
                <h3 class="rubik fs-2 mb-1">Mis clases</h3>
                <p class="rubik fs-5-5 opacity-75">
                    Reserva nuevas clases y revisa tu historial.
                </p>
            </section>

            {{-- CLASES DISPONIBLES --}}
            <section class="px-5 mb-5">
                <div class="d-flex align-items-center mb-3">
                    <i class="fa-regular fa-calendar fs-5 text-green-btn me-2"></i>
                    <h3 class="rubik fs-3 mb-0">Clases disponibles</h3>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">

                    <div class="col p-2">
                        <div class="card rounded-4 class-card green">
                            <div class="card-body">

                                <span class="badge bg-green-btn text-white mb-2">
                                    Disponible
                                </span>

                                <h5 class="card-title mb-1">
                                    Clase Práctica #12
                                </h5>

                                <p class="card-text opacity-75">
                                    Maniobras en rotondas
                                </p>

                                <div class="class-meta mt-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fa-regular fa-calendar me-2"></i>
                                        <span>18/05/2026</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fa-regular fa-clock me-2"></i>
                                        <span>10:00 - 11:00</span>
                                    </div>
                                </div>

                                <hr class="my-3">

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-placeholder"></div>
                                        <span class="ms-2 opacity-75">
                                            Prof. Juan Martínez
                                        </span>
                                    </div>

                                    {{-- BOTÓN EN LA TARJETA (SE MANTIENE) --}}
                                    <button
                                        class="btn bg-green-btn text-white reserve-card-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#reserves">
                                        Reservar
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </section>

            {{-- PRÓXIMAS CLASES RESERVADAS --}}
            <section>
                <div class="d-flex align-items-center px-5 mb-3">
                    <i class="fa-regular fa-calendar-check fs-5 me-2 text-green-btn"></i>
                    <h3 class="rubik fs-3 mb-0">
                        Próximas clases reservadas
                    </h3>
                </div>

                <div class="container-fluid my-4">
                    <div class="card reserved-table-card rounded-4">
                        <div class="card-body p-0 table-responsive">
                            <table class="table mb-0 align-middle reserved-table">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Clase</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Profesor</th>
                                        <th class="pe-4">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-semibold">
                                                Clase #13
                                            </div>
                                            <small class="text-muted">
                                                Conducción urbana
                                            </small>
                                        </td>
                                        <td>20/05/2026</td>
                                        <td>12:30 - 13:30</td>
                                        <td>Juan Martínez</td>
                                        <td class="pe-4">
                                            <span class="badge bg-warning text-dark px-3 py-2">
                                                Confirmada
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-semibold">
                                                Clase #14
                                            </div>
                                            <small class="text-muted">
                                                Aparcamiento en batería
                                            </small>
                                        </td>
                                        <td>22/05/2026</td>
                                        <td>10:00 - 11:00</td>
                                        <td>Ana López</td>
                                        <td class="pe-4">
                                            <span class="badge bg-green-btn text-white px-3 py-2">
                                                Reservada
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

    {{-- MODAL --}}
    <div class="modal fade" id="reserves" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reservar Clase</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Fecha</label>
                            <select class="form-select">
                                <option>18/05/2026</option>
                                <option>19/05/2026</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hora</label>
                            <select class="form-select">
                                <option>10:00 - 11:00</option>
                                <option>12:30 - 13:30</option>
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Profesor</label>
                            <select class="form-select">
                                <option>Juan Martínez</option>
                                <option>Ana López</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn bg-green-btn text-white w-100">
                            Confirmar reserva
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include("partials.footer")
    @include("partials.scripts")
</body>
</html>