<?php
    session_start();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="swiper.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11.1.14/swiper-bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/swiper@11.1.14/swiper-bundle.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Clap</title>
</head>
<body class="overflow-x-hidden">
    
    <?php
        include 'header.php';
    ?>
    <main class="container">
        <div id="swiper-container1" class="swiper">
            <div class="swiper-wrapper" id="descuentos">
                <div class="swiper-slide"><img src="../src/img/71WR45NFLgL.jpg" alt="" style="object-fit: fit" height="700"></div>
                <div class="swiper-slide"><img src="../src/img/1366_2000.png" alt=""></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <h2>Products</h2>
        <div id="swiper-container" class="swiper">
            <div class="swiper-wrapper" id="products"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
        
        <h2>Popular categories</h2>
        <section id="popular-categories container row">
            <article class="col"><img src="" alt=""></article>
            <article class="col"><img src="" alt=""></article>
            <article class="col"><img src="" alt=""></article>
            <article class="col"><img src="" alt=""></article>
            <article class="col"><img src="" alt=""></article>
            <article class="col"><img src="" alt=""></article>
            <article class="col"><img src="" alt=""></article>
            <article class="col"><img src="" alt=""></article>
            <article class="col"><img src="" alt=""></article>   
            <article class="col"><img src="" alt=""></article>
        </section>
    </main>
    <?php include 'footer.php'?>
    <script src="/UTU-project/interfaz/src/scripts/carrousel.js"></script>
    <script type="module" src="/UTU-project/interfaz/src/scripts/products/openProduct.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/products/showProducts.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/finder.js"></script>
<script src="/UTU-project/interfaz/src/scripts/udateURL.js"></script>
<script src="/UTU-project/interfaz/src/scripts/usuario/logout.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/addProductCarrito.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/removeProductCarrito.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/showProductCarrito.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/showTotalPriceCarrito.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/usuario/insertHistory.js"></script>
  <script src="/UTU-project/interfaz/src/scripts/buyCart.js"></script>
</body>
</html>
