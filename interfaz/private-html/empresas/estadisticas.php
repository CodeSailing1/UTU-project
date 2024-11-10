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
    <body class="row">
    <?php
    session_start();
    if (!isset($_SESSION['loginEmpresa'])) {
        header("location: /UTU-project/interfaz/public-html/index.php");
    }
    include 'header.php' ?>
        <div class="nav-item d-flex flex-column gap-3 col-1 bg-body-tertiary hv-100">
            <a class="btn btn-outline-success">Inicio</a>
            <a class="btn btn-outline-success" href="./abm/agregarEmpresas.php">ABM</a>
            <a class="btn btn-outline-success" href="./inventario.php">Inventario</a>
            <a class="btn btn-outline-success" href="./estadisticas.php">Estadisticas</a>
            <a class="btn btn-outline-success">Perfil</a>
        </div>
        <div class="col-11">
        <main class="container col">
            <aside id="options" class="list-group d-flex flex-row justify-content-center align-items-center gap-5" style="width:100wv">
                        <button type="button" class="btn btn-outline-success me-2 pestania" id="productos">Productos</button>
                        <button type="button" class="btn btn-outline-secondary me-2 pestania" id="ventas">Ventas</button>
                        <button type="button" class="btn btn-outline-secondary me-2 pestania" id="vistas">Vistas </button>
                        <button type="button" class="btn btn-outline-secondary me-2 pestania" id="comentarios">Comentarios </button>
            </aside>
            <div class="productos d-block" style="height: 80vh;">
                    <div class="chart-container row">
                        <div class="col m-2">
                            <h3>Ranking de productos mas vendidos</h3>
                            <canvas id="productosVendidos"></canvas>
                        </div>
                        <div class="col m-2">
                            <h3>Ranking de productos menos vendidos</h3>
                            <canvas id="productosMenosVendidos"></canvas>
                        </div>
                    </div>
                <table class="w-100" id="stock">
                    <h3>Productos con menos stock</h3>
                        <thead>
                            <tr class="border-bottom">
                            <th class="m-2">Nombre</th>
                                <th class="m-2">id</th>
                                <th class="m-2">stock</th>
                            </tr>
                        </thead>

                    </table>
            </div>
            <div class="ventas container row m-3 d-flex d-none" height="" style="overflow: auto; height:80vh;">
                <h2>Ventas</h2>
                <div class="chart-container row">
                                        <div class="col m-2">
                                            <h3>Ventas por anio</h3>
                                            <canvas id="ventasPorAnio"></canvas>
                                        </div>

                                    </div>
                </div>

            <div class="vistas  d-none">
                <h2>Vistas</h2>
                <div class="chart-container row">
                        <div class="col m-2">
                            <h3>Personas que mas visitan productos de la empresa</h3>
                            <canvas id="personasFieles"></canvas>
                        </div>
                    <div class="col m-2">
                            <h3>Personas que mas visitan productos de la empresa</h3>
                            <canvas id="visitasPorProductos"></canvas>
                        </div>
                    </div>
            </div>
         <div class="comentarios  d-none">
                        <h2>Comentarios</h2>
                        <section id="comentariosRecientes" class="container row m-3 overflow-auto" style="height:75vh; width: 100vw">
                                </section>
                    </div>

        </main>
        </div>
        <script src="/UTU-project/interfaz/private-html/cambiarPestanias.js"></script>
        <script src="/UTU-project/interfaz/private-html/empresas/graficas/productosMasVendidos.js"></script>
        <script src="/UTU-project/interfaz/private-html/empresas/graficas/productosMenosVendidos.js"></script>
        <script src="/UTU-project/interfaz/private-html/empresas/graficas/productosConStockBajo.js"></script>
        <script src="/UTU-project/interfaz/private-html/empresas/graficas/personasMasFieles.js"></script>
        <script src="/UTU-project/interfaz/private-html/empresas/graficas/visitasPorProducto.js"></script>
        <script src="/UTU-project/interfaz/private-html/empresas/graficas/totalVentasAnio.js"></script>
        <script src="/UTU-project/interfaz/private-html/empresas/graficas/comentariosMasRecientes.js"></script>
<script src="./scripts/logout.js"></script>
        
    </body>
    </html>