<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Backoffice - Clap</title>
</head>
<body class="row">
<?php
session_start();
if (!isset($_SESSION['loginEmpresa'])) {
    header("location: /UTU-project/interfaz/public-html/index.php");
}
include 'header.php' ?>

            
    <div class="nav-item btn-group-vertical gap-3 col-1 bg-body-tertiary hv-100">
        <a class="btn btn-outline-success">Inicio</a>
        <a class="btn btn-outline-success" href="./abm/agregarEmpresas.php">ABM</a>
        <a class="btn btn-outline-success" href="./empresas/inventario.php">Inventario</a>
        <a class="btn btn-outline-success" href="./estadisticas.php">Estadisticas</a>
        <a class="btn btn-outline-success">Perfil</a>
    </div>
    <main class="col-2">
        <div id="productosInventario">

        </div>
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </main>
    <script src="../src/scripts/history.js"></script>
    <script src="../src/scripts/showProduts.js"></script>
<script src="./scripts/logout.js"></script>

</body>
</html>