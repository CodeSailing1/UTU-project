<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="producto.css">
    <title>Document</title>
</head>
<body>
    <?php
        include 'header.php';
    ?>
    <main>
        <section id="product-images">
            
            <img src="/UTU-project/interfaz/src/img/wesley-tingey-Bh_eNLH30kc-unsplash.jpg" alt="" id="principal-image">

        </section>
        <aside id="product-data">
            <h3><?php
                $nombreProducto
            ?></h3>
            <p>Valoracion</p>
            <form action="" method="POST">
                <input type="button" value="Agregar al carrito">
                <em>
                    <ul>
                        <li><?php echo $example ?></li>
                        <li><?php echo $example ?></li>
                        <li><?php echo $example ?></li>
                        <li><?php echo $example ?></li>
                        <li><?php echo $example ?></li>
                    </ul>
                </em>
            </form>
        </aside>
        <section id="product-description">
            <?php echo "<h2>Descripcion del producto</h2>";
                    echo $descripcionProducto;
            ?>            
        </section>
        <?php include 'footer.php'?>
    </main>
</body>
</html>