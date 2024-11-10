<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>

<body class="row overflow-x-hidden">
    <?php
    session_start();
    ?>
    <?php
    include 'header.php';
    ?>

    <aside class=" flex-shrink-0 p-3  vh-100 col-2">
        <div class="list-group flex-column m-3">
            <h2>Categories</h2>
            <div class="d-flex">
                <input type="button" class="category my-2 list-group-item categories btn btn-light w-100 p-100"
                    aria-current="page" value="Clear category">

            </div>

            </input>
            <button type="button" class="category my-2 list-group-item categories btn btn-light w-100 p-100"
                aria-current="page">
                juegos y consolas
            </button>
            <button type="button" class="category my-2 list-group-item categories btn btn-light w-100 p-100"
                aria-current="page">
                musica
            </button>
            <button type="button" class="category my-2 list-group-item categories btn btn-light w-100 p-100"
                aria-current="page">
                libros
            </button>
            <button type="button" class="category my-2 list-group-item categories btn btn-light w-100 p-100"
                aria-current="page">
                celulares
            </button>
            <button type="button" class="category my-2 list-group-item categories btn btn-light w-100 p-100"
                aria-current="page">
                ropa

            </button>
        <button type="button" class="category my-2 list-group-item categories btn btn-light w-100 p-100"
                        aria-current="page">
                        muebles

                    </button>
                <button type="button" class="category my-2 list-group-item categories btn btn-light w-100 p-100"
                                aria-current="page">
                                deportes

                            </button>
                        <button type="button" class="category my-2 list-group-item categories btn btn-light w-100 p-100"
                                        aria-current="page">
                                        joyeria

                                    </button>
                                <button type="button" class="category my-2 list-group-item categories btn btn-light w-100 p-100"
                                                aria-current="page">
                                                herramientas

                                            </button>
                                        <button type="button" class="category my-2 list-group-item categories btn btn-light w-100 p-100"
                                                        aria-current="page">
                                                        salud

                                                    </button>
                                                <button type="button" class="category my-2 list-group-item categories btn btn-light w-100 p-100"
                                                                                                        aria-current="page">
                                                                                                        belleza

                                                                                                    </button>
        </div>
    </aside>
    <main class="container col">
        <section id="products" class="row grid gap-0 row-gap-3">

        </section>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </main>

    <?php include 'footer.php' ?>
    <script src="/UTU-project/interfaz/src/scripts/products/showProducts.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/products/categories.js"></script>
    <script type="module" src="/UTU-project/interfaz/src/scripts/products/openProduct.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/finder.js"></script>
<script src="/UTU-project/interfaz/src/scripts/udateURL.js"></script>
<script src="/UTU-project/interfaz/src/scripts/usuario/logout.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/addProductCarrito.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/removeProductCarrito.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/showProductCarrito.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/showTotalPriceCarrito.js"></script>
  <script src="/UTU-project/interfaz/src/scripts/buyCart.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/usuario/insertHistory.js"></script>
</body>

</html>