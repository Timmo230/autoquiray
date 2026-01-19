<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    require "./partials/links.php";
    ?>
</head>
<body>
    <?php
    require "./partials/nav.php";
    ?>

    <main>
        <article>
            <section class="row row-cols-1 row-cols-sm-2">
                <div class="col">
                    <h3>Mis clases</h3>
                    <p>Gestiona tus clases practicas  de conduccion</p>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reserves">Vertically centered modal</button>
                </div>

            </section>
            <section></section>
            <section></section>
        </article>
    </main>

    <div class="modal fade show" id="reserves" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: block;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalCenterTitle">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>This is a vertically centered modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>
</body>
</html>