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
    <title>Document</title>
</head>
<body class="d-flex flex-column justify-content-center align-items-center">
    <?php
    session_start();
    include 'header.php';
    ?>
    <main id="productPlace" class="container my-3">
    
    </main>
    <div id="swiper-container" class="swiper container">
        <div class="swiper-wrapper" id="products"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
    <section id="comentarios" class="d-flex flex-column align-items-center container">
        <form action="" class="d-flex flex-column w-100 form" id="formComment">
            <textarea name="comment" id="comment" cols="1000" rows="2" class="form-control"></textarea>
            <div class="d-flex justify-content-between align-items-center">
                <input type="submit" value="Enviar" class="btn btn-outline-success my-2" id="sendComment" disabled>
                <span id="characters" class="d-none"></span>
                <span id="charactersShown">300</span>
            </div>
        </form>
        <article id="sectionComments" class="container w-100" style="height: 50vh; overflow: auto;">
        </article>
    </section>
    <?php
    include 'footer.php'
    ?>
    <script src="/UTU-project/interfaz/src/scripts/products/showProducts.js"></script>
    <script type="module" src="/UTU-project/interfaz/src/scripts/products/productPage.js"></script>
    <script type="module"src="/UTU-project/interfaz/src/scripts/products/openProduct.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/comentarios/showComentarios.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/comentarios/addComentario.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/finder.js"></script>
<script src="/UTU-project/interfaz/src/scripts/udateURL.js"></script>
<script src="/UTU-project/interfaz/src/scripts/usuario/logout.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/addProductCarrito.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/removeProductCarrito.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/showProductCarrito.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/showTotalPriceCarrito.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/usuario/insertHistory.js"></script>
  <script type="module" src="/UTU-project/interfaz/src/scripts/usuario/insertViewedIntoProduct.js"></script>
  <script src="/UTU-project/interfaz/src/scripts/buyCart.js"></script>
</body>
</html>