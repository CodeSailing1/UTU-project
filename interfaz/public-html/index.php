<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Clap</title>
</head>
<body>
    <?php
    session_start();
    include_once '/xampp/htdocs/UTU-project/logica/functions.php';
    ?>
    <?php
        include 'header.php';
    ?>
    <div id="separator"></div>
    <main>
        <div class="carrousel-container" id="promotions">
            <button id="prevBtn">Previous</button>
            <div id="imagen" class="carrousel-slide">
            </div>
            <button id="nextBtn">Next</button>
        </div>
        <h2>Products</h2>
        <div id="discounts">
            <div id="products">
    
            </div>
        </div>
        <h2>Popular categories</h2>
        <section id="popular-categories">
            <article><img src="../src/img/11-mitos-electrodomesticos-hora-dejes-creerte-2157733.png" alt=""></article>
            <article><img src="../src/img/1366_2000.png" alt=""></article>
            <article><img src="../src/img/13934903_1648619525452720_2900498051237894535_n.png" alt=""></article>
            <article><img src="../src/img/6a94926d20190a841f93b405eef7414a.png" alt=""></article>
            <article><img src="../src/img/depositphotos_241907032-stock-photo-top-view-watches-lipstick-earrings.png" alt=""></article>
            <article><img src="../src/img/herramientas-manuales-basicas-02-2022-07.png" alt=""></article>
            <article><img src="../src/img/Jm3lXndQW_2000x1500__1.png" alt=""></article>
            <article><img src="../src/img/Musique-2.png" alt=""></article>
            <article><img src="../src/img/png-mobile-phone-png-icns-more-512.webp" alt=""></article>   
            <article><img src="../src/img/Z5CCK4LQ44JIM6BWFUMIPN2SZI.png" alt=""></article>
        </section>
    </main>
    <?php include 'footer.php'?>
    <script src="/UTU-project/interfaz/src/scripts/carrousel.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/shoppingCart.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/udateURL.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/showProducts.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/logout.js"></script>

</body>
</html>
