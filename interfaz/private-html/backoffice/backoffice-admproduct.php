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
    <main class="col my-5">
        <aside id="options" class="list-group d-flex flex-row justify-content-center align-items-center gap-5" style="width:100wv">
            <button type="button" class="btn btn-outline-success me-2 pestania" id="listadoProductos">Listado de Productos</button>
            <button type="button" class="btn btn-outline-secondary me-2 pestania" id="modificarProducto">Modificar producto</button>
            <button type="button" class="btn btn-outline-secondary me-2 pestania" id="inventarioEmpresa">Inventario por empresa </button>
        </aside>
        <div class="listadoProductos d-block" style="height: 80vh; overflow: auto;">
            <h2>Listado de Productos</h2>
            <table class="table" id="listado">
                <thead class="thead-dark">
                    <tr class="">
                        <th class="m-2" scope="col">Foto de Producto</th>
                        <th class="m-2" scope="col">Id</th>
                        <th class="m-2" scope="col">Nombre</th>
                        <th class="m-2" scope="col">Stock</th>
                        <th class="m-2" scope="col">Precio</th>
                        <th class="m-2" scope="col">Categoria</th>
                        <th class="m-2" scope="col">Fecha</th>
                        <th class="m-2" scope="col">Valoracion</th>
                        <th class="m-2" scope="col">Visitas</th>
                        <th class="m-2" scope="col">Compras</th>
                        <th class="m-2" scope="col">Inactivo</th>
                        <th class="m-2" scope="col">Empresa duenia</th>
                    </tr>
                </thead>

            </table>
        </div>
        <div class="modificarProducto container row m-3 d-flex d-none" height="" style="overflow: auto; height:80vh;"></div>

        <div class="inventarioEmpresa  d-none">
            <h1>estas</h1>
        </div>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered p-5">
                <div class="modal-content p-5">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Modificacion de producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="" class="form-group row" name="modify" id="modABM">
                        <label>Id<input class="form-control" id="idInput" name="id" value=""></label>
                        <label class="col-form-label">
                            Nombre
                            <input type="text" name="name" class="form-control">
                        </label>
                        <label>
                            Precio
                            <input type="number" name="price" class="form-control">
                        </label>
                        <label>
                            Categoria
                            <select class="form-control" name="category">
                                <option value="">----</option>
                                <option value="">Juguetes</option>
                                <option value="">Tecnologia</option>
                                <option value="">Maquinaria</option>
                                <option value="">Escolares</option>
                                <option value="">Comida</option>
                            </select>
                        </label>
                        <label>
                            Descripcion
                            <input type="text" name="description" class="form-control">
                        </label>
                        <label>
                            Imagen
                            <input type="file" name="img" class="form-control-file">
                        </label>
                    </form>
                    </form>

                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-secundary" id="modificarProducto" form="modABM">Si</button>
                    </div>
                    </div>
                </div>
            </div>
    </main>
    <script src="./scripts/abmProductos/modificacion.js"></script>
    <script src="/UTU-project/interfaz/private-html/cambiarPestanias.js"></script>
    <script src="./scripts/abmProductos/listadoProductos.js"></script>
    <script src="./scripts/abmProductos/showProducts.js"></script>
</body>

</html>