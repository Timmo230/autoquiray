<ul class="navbar-nav">
    <?php if($uri == "/PROYECTO/web/index.php"): ?>
        <li class="nav-item">
            <a class="nav-link active" href="./index.php" id="actualPg">Inicio</a>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <a class="nav-link" href="./index.php">Inicio</a>
        </li>
    <?php endif?>
    
    <?php if ($uri == "/PROYECTO/web/tests.php"): ?>
        <li class="nav-item">
            <a class="nav-link active" href="./tests.php" id="actualPg">Tests Online</a>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <a class="nav-link" href="./tests.php">Tests Online</a>
        </li>
    <?php endif ?>
    

    <?php if($uri == "/PROYECTO/web/classes.php"): ?>
        <li class="nav-item">
            <a class="nav-link active" href="./classes.php" id="actualPg">Mis Clases</a>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <a class="nav-link" href="./classes.php">Mis Clases</a>
        </li>
    <?php endif?>

    
    <?php if($uri == "/PROYECTO/web/contacto.php"): ?>
        <li class="nav-item">
            <a class="nav-link active" href="./contacto.php" id="actualPg">Atención al Cliente</a>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <a class="nav-link" href="./contacto.php">Atención al Cliente</a>
        </li>
    <?php endif?>
    


    <li class="nav-item"><a class="nav-link" href="#">Zona Profesores</a></li>
</ul>