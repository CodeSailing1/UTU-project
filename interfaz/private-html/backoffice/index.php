<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/UTU-project/frameworks/chart.umd.min.js"></script>


    <title>Backoffice - Clap</title>
</head>
<body class="row m-0">
    <?php
    session_start();
//     if (!isset($_SESSION['loginAdmin'])) {
//         header("location: /UTU-project/interfaz/private-html/backoffice/login.html");
//     }
     ?>
    <header class="col-1">
        <div class=" nav flex-column  align-items-center bg-body-tertiary  w-100 p-2">
                <div class="nav-item btn-group-vertical gap-3">
                <a class="btn btn-outline-success" href="backoffice.php">Estadisticas</a>
                <a class="btn btn-outline-success" href="./backoffice-admproduct.php">Productos</a>
                <a class="btn btn-outline-success">Usuarios</a>
                <a class="btn btn-outline-success">Empresas</a>
                <a class="btn btn-outline-success">Tickets</a>
                </div>
        </di>
    </header>
    <main class="col d-flex justify-content-center align-items-center">
    <div class="container-fluid">
        <div class="chart-container row" style="  ">
            <div class="col m-2">
                <h3>Cantidad de usuario por tipo</h3>
                <canvas id="usuariosChart" ></canvas>
            </div>
            <div  class="col m-2">
                <h3>Ranking de empresas por venta de productos</h3>

                <canvas id="myChart" ></canvas>
            </div>
         <div class="w-100"></div>
            <div class="col m-2" >
                <h3>Ranking de usuarios por compra de productos</h3>

                <canvas id="comprasUsuario" ></canvas>
            </div>
            <div class="col m-2">
                <h3>Ranking de productos mas vendidos</h3>

                <canvas id="productosMasVendidos"  ></canvas>
            </div>
        </div>
    </div>
    </main>
    <script src="./scripts/estadisticas/ventasEmpresasAnio.js"></script>
    <script src="./scripts/estadisticas/cantidadUsuarios.js"></script>
    <script src="./scripts/estadisticas/rankingComprasUsuario.js"></script>
    <script src="./scripts/estadisticas/rankingProductosMasVendidos.js"></script>

    <script src="../src/scripts/history.js"></script>
    <script src="../src/scripts/showProduts.js"></script>
</body>
</html>