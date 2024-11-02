<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="categorias.css">
    <title>Document</title>
</head>
<body>
    <?php
    session_start();
    if ($_SERVER['REQUEST_URI'] === "http://localhost/UTU-project/interfaz/public-html/finder.php"){
        include '/UTU-project/logica/showProducts.php';
    }
    ?>
    
    <div id="categories">
        <?php
        include 'header.php';
        ?>
        <section id="search-section">
            <div id="search-bar"><form action="" method="POST" id="finder">
            <label for="search"></label><input type="search" name="search" id="finderResult"><input type="submit">
            </form></div>
        </section>
        <aside>
            <h2>Categories</h2>
            <ul class="category-list">
                <li>
                    Category
                </li>
                <li>
                    Category
                </li>
                <li>
                    Category
                </li>
                <li>
                    Category
                </li>
                <li>
                    Category
                </li>
            </ul>
        </aside>
        <main>
            <section id="products">
            
                
            </section>
        </main>
        
    </div>
    <?php include 'footer.php'?>

    <script src="/UTU-project/interfaz/src/scripts/shoppingCart.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/showProducts.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/finder.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/udateURL.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/logout.js"></script>
</body>
</html>