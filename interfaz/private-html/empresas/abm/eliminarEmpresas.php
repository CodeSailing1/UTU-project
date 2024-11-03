<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <title>Backoffice - Clap</title>
</head>

<body class="row">
    <?php
    session_start();
    if (!isset($_SESSION['loginEmpresa'])) {
        header("location: /UTU-project/interfaz/public-html/index.php");
    }
    ?>
    <?php include '../header.php' ?>


    <div class="nav-item d-flex flex-column gap-3 col-1 bg-body-tertiary hv-100">
        <a class="btn btn-outline-success">Inicio</a>
        <a class="btn btn-outline-success">Productos</a>
        <a class="btn btn-outline-success">Estadisticas</a>
        <a class="btn btn-outline-success">Perfil</a>
    </div>
    <main class="col ">
        <aside id="options" class="list-group d-flex flex-row justify-content-center align-items-center gap-5"
            style="width:100wv">
            <a href="agregarEmpresas.php" class="btn btn-outline-secondary me-2">agregar</a>
            <a href="eliminarEmpresas.php" class="btn btn-outline-success me-2">eliminar</a>
            <a href="modificarEmpresas.php" class="btn btn-outline-secondary me-2">modificar</a>
        </aside>

        <div class="row d-flex justify-content-center my-5" style="width: 100wv; height:100hv;">

            <section class="row col-5 d-flex justify-content-center align-items-center">
                <div class="d-flex">
                    <form class="col d-flex w-50" role="search" id="finder">
                        <input class="form-control " type="search" placeholder="Search" aria-label="Search"
                            id="finderResult">
                        <button class="btn btn-outline-success" type="submit" id="search">Search</button>
                    </form>
                </div>
                <div id="products" class="container row m-3 overflow-auto" style="height:500px">

                </div>
            </section>
            <div class="vr p-0 m-5"></div>
            <section class="col-5 ">
                <h3>Productos eliminados recientemente:</h3>
                Coming soon...
            </section>
        </div>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Esta seguro que desea eliminar este producto?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-secundary" id="eliminarProducto">Si</button>
      </div>
    </div>
  </div>
</div>
    </main>
    <script src="../scripts/showProductById.js"></script>
    <script src="../scripts/udateURL.js"></script>
    <script src="../scripts/bajas.js"></script>
</body>

</html>