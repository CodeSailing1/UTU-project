<header>
    <nav>
        <a href="/UTU-project/interfaz/public-html/index.php"><img src="../src/img/Claptransparente.png" alt="#" class="logo"></a>
        <?php if ($_SERVER['REQUEST_URI'] === "/UTU-project/interfaz/public-html/finder.php"): ?>
        <?php else:?>
            <?php
            $searchTerm = $_GET['searchTerm'] ?? '';
            if($_SERVER['REQUEST_URI'] === "/UTU-project/interfaz/public-html/finder.php?searchTerm=$searchTerm"):?>
            <?php else:?>
                <div id="search-bar">
                    <ul>
                        <li class="dropdown">Categories
                            <div class="dropdown-content">
                                <ul>
                                    <li>Sales</li>
                                    <li>Books</li>
                                    <li>Music</li>
                                    <li>Mobile Phones</li>
                                    <li>Clothes</li>
                                    <li>Furniture</li>
                                    <li>Sports</li>
                                    <li>Jewerly</li>
                                    <li>Helth and care</li>
                                    <li>Tools</li>
                                    <li>Videogames and consoles</li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <form action="/search" method="POST" id="finder">
                        <label for="search"></label>
                        <input type="search" name="search" id="finderResult">
                        <input type="submit" name="submit" value="Search" id="search">
                    </form>
                </div>
            <?php endif?>
        <?php endif; ?>
        <ul>
            <li class="dropdown">
                <a href="./shoppingCart.html" class="dropbtn"><img src="../src/img/svgs/shopping-cart.svg" alt="#"></a>
            </li>
            <li><a href="./help.html"><img src="../src/img/svgs/help.svg" alt="Help icon"></a></li>
            <?php if (isset($_SESSION['login'])): ?>
                <li>
                    <span class="user-name"><?php echo $_SESSION['nombre']; ?></span>
                </li>
                <li><button id="logout">logout</button></li>
            <?php else: ?>
                <li><a href="/UTU-project/interfaz/public-html/register.html" id="register-button">register</a></li>
                <li><a href="/UTU-project/interfaz/public-html/login.html" id="login-button">login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>