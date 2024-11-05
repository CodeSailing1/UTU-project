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
    <?php include '../header.php'; ?>


    <div class="nav-item d-flex flex-column gap-3 col-1 bg-body-tertiary hv-100">
        <a class="btn btn-outline-success">Inicio</a>
        <a class="btn btn-outline-success" href="./abm/agregarEmpresas.php">ABM</a>
        <a class="btn btn-outline-success" href="../inventario.php">Inventario</a>
        <a class="btn btn-outline-success" href="../estadisticas.php">Estadisticas</a>
        <a class="btn btn-outline-success">Perfil</a>
    </div>
    <main class="col ">
        <aside id="options" class="list-group d-flex flex-row justify-content-center align-items-center gap-5" style="width:100wv">
            <a href="agregarEmpresas.php" class="btn btn-outline-success me-2">agregar</a>
            <a href="eliminarEmpresas.php" class="btn btn-outline-secondary me-2">eliminar</a>
            <a href="modificarEmpresas.php" class="btn btn-outline-secondary me-2">modificar</a>
            <a href="activarEmpresas.php" class="btn btn-outline-secondary me-2">activar</a>

        </aside>
        <div class="row d-flex justify-content-center my-5" style="width: 100wv; height:100hv;">

            <section class="col-5 ">
                <form action="" class="form-group row" id="altasABM" method="POST">
                    <label class="col-form-label">
                        Nombre
                        <input name="name" type="text" class="form-control">
                    </label>
                    <label>
                        Precio
                        <input name="price" type="number" class="form-control">
                    </label>
                    <label>
                        Categoria
                        <select name="category" class="form-control">
                            <option value="----">----</option>
                            <option value="">----</option>
                            <option value="">juegos y consolas</option>
                            <option value="">musica</option>
                            <option value="">libros</option>
                            <option value="">celulares</option>
                            <option value="">ropa</option>
                            <option value="">muebles</option>
                            <option value="">deportes</option>
                            <option value="">joyeria</option>
                            <option value="">herramientas</option>
                            <option value="">salud</option>
                            <option value="">belleza</option>
                        </select>
                    </label>
                    <label>
                        Descripcion
                        <input name="description" type="text" class="form-control">
                    </label>
                    <label>
                        Imagen
                        <input name="img" type="file" class="form-control-file">
                    </label>
                    <label>
                        Cantidad
                        <input name="stock" type="number" class="form-control-file">
                    </label>
                    <label><input type="submit" value="Aceptar" class="btn btn-success" id="submit"></label>
                </form>

            </section>
                <div class="vr p-0"></div>
                <section class="col-5 ">
                <h3>Productos agregados recientemente:</h3>
                Coming soon...
            </section>
        </div>
    </main>
    <script src="../scripts/altas.js"></script>
<script src="../scripts/logout.js"></script>

</body>

</html>