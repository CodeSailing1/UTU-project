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
    if(!isset($_SESSION["login"])){
        header("location: /UTU-project/interfaz/public-html/index.php");
    }
    ?>
    <?php
    include 'header.php';
    ?>

    <aside class=" flex-shrink-0 p-3  vh-100 col-2">
        <div class="list-group flex-column m-3">

            </input>
            <a href="./historial.php" class=" my-2 list-group-item  btn btn-light w-100 p-100"
                >
                Historial General
            </a>
            <a href="./historialComprado.php" class=" my-2 list-group-item  btn btn-light w-100 p-100"
                >
                Compras
            </area>
            <a href="./historialVisto.php" class=" my-2 list-group-item  btn btn-light w-100 p-100"
                >
                Visitados
            </a>
        </div>
    </aside>
    <main class="container col">
    <section class="row grid gap-0 m-3 px-5" style="height: 80vh; overflow: auto;">
    <table class="w-100" id="history">
        <thead>
            <tr class="border-bottom">
            <th class="m-2">Foto de Producto</th>
                <th class="m-2">Nombre</th>
                <th class="m-2">Cantidad</th>
                <th class="m-2">Precio</th>
                <th class="m-2">Fecha</th>
                <th class="m-2">Tipo</th>
            </tr>
        </thead>
        
    </table>
</section>

        <section id="historyCompra" class="row grid gap-0 row-gap-3">

        </section>
        <section id="historyViewed" class="row grid gap-0 row-gap-3">

        </section>
    </main>

    <?php include 'footer.php' ?>
    <script src="/UTU-project/interfaz/src/scripts/finder.js"></script>
<script src="/UTU-project/interfaz/src/scripts/udateURL.js"></script>
<script src="/UTU-project/interfaz/src/scripts/usuario/logout.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/addProductCarrito.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/removeProductCarrito.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/showProductCarrito.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/showTotalPriceCarrito.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/products/openProduct.js"></script>

  <script src="/UTU-project/interfaz/src/scripts/buyCart.js"></script>
  <script src="/UTU-project/interfaz/src/scripts/usuario/showHistory.js"></script>
</body>

</html>