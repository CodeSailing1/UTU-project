<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Ayuda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style-help.css">
</head>


<body>
<?php
    session_start();
    ?>
    <?php
    include 'header.php';
    ?>
    
    <main>
        <section class="intro">
            <h2>¿Cómo podemos ayudarte?</h2>
            <p>Aquí encontrarás respuestas a las preguntas más frecuentes. Si necesitas más ayuda, no dudes en <a href="#contact">contactarnos</a>.</p>
        </section>

        <section class="faq">
            <h2>Preguntas Frecuentes</h2>

            <div class="faq-item">
                <button class="faq-question">¿Cómo realizo una compra?</button>
                <div class="faq-answer">
                    <p>Para realizar una compra, selecciona el producto que deseas, agrégalo al carrito y sigue los pasos para completar el pago.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">¿Cuáles son los métodos de pago aceptados?</button>
                <div class="faq-answer">
                    <p>Aceptamos tarjetas de crédito, débito, y pagos por plataformas como PayPal y MercadoPago.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">¿Cómo puedo rastrear mi pedido?</button>
                <div class="faq-answer">
                    <p>Una vez que tu pedido haya sido enviado, recibirás un código de seguimiento por correo electrónico. Ingresa este código en nuestra página de rastreo para conocer el estado de tu pedido.</p>
                </div>
            </div>
        </section>

        <section class="contact" id="contact">
            <h2>Contacto</h2>
            <p>Si tienes otras preguntas, puedes escribirnos a CodeSailing@gmail.com</a>.</p>
        </section>
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
    <script src="script-help.js"></script>
</body>
</html>
