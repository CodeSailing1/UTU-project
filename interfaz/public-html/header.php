<header class="w-100 ">
  <nav class=" navbar navbar-expand-lg bg-body-tertiary w-100 p-2">
    <!-- Logo -->
    <a class="navbar-brand " href="/UTU-project/interfaz/public-html/index.php">
      <img src="../src/img/Claptransparente.png" alt="Logo" class="logo" height="75">
    </a>

    <!-- Botón de colapso para pantallas pequeñas -->

    <!-- Menú colapsable -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    <div class=" justify-content-between collapse navbar-collapse" id="navbarSupportedContent">

      <!-- Dropdown de categorías -->
      <button class="col-lg-1 col-sm-12 nav-item dropdown btn btn-outline-success me-2" type="button">
        <div class="row">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Dropdown
        </a>
        <ul class="dropdown-menu z-3 col-sm-12 col-lg-12">
          <li><a class="dropdown-item" href="#">Juguetes
            </a></li>
          <li><a class="dropdown-item" href="#">Tecnologia</a></li>
          <li><a class="dropdown-item" href="#">Maquinaria</a></li>
          <li><a class="dropdown-item" href="#">Escolares</a></li>
          <li><a class="dropdown-item" href="#">Comida</a></li>
        </ul>
        </div>
      </button>

      <!-- Formulario de búsqueda (solo visible en pantallas grandes) -->
      <form class="col-lg-5 col-sm-12 d-flex p-0" role="search" id="finder">
        <input class="form-control " type="search" placeholder="Search" aria-label="Search" id="finderResult">
        <button class="btn btn-outline-success" type="submit" id="search">Search</button>
      </form>


      <!-- Iconos de carrito de compras y ayuda -->

      <ul class=" col-lg-2 col-sm-12 list-group d-flex flex-row justify-content-center align-items-center p-0">
        <li class="list-group-item border-0 bg-body-tertiary p-0">
          <a class="btn btn-outline-success me-2" data-bs-toggle="offcanvas" href="#offcanvasRight" role="button"
            aria-controls="offcanvasRightLabel">
            <img src="../src/img/svgs/shopping-cart.svg" alt="Shopping Cart">
          </a>
        </li>
        <li class="list-group-item border-0 bg-body-tertiary p-0">
          <a href="./help.php" class="btn btn-outline-success me-2">
            <img src="../src/img/svgs/help.svg" alt="Help Icon">
          </a>
        </li>

        <!-- Verificación de sesión -->
        <?php if (isset($_SESSION['login'])): ?>
          <button class="nav-item dropstart border-0 bg-transparent " type="button">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img class="navbar-brand object-fit-cover"
                src="/UTU-project/persistencia/assets/<?php echo $_SESSION['imagenUsuario']; ?>" height="50" width="50" style="border-radius: 50%;">
            </a>
            <ul class="dropdown-menu z-3">
              <li class="dropdown-item border-0 p-0">
                <a href="/UTU-project/interfaz/public-html/profile.php" class="btn w-100">Profile</a>
              </li>
              <li class="dropdown-item border-0 p-0">
                <a href="/UTU-project/interfaz/public-html/historial.php" class="btn w-100">Historial</a>
              </li>

              <li class="dropdown-item border-0 p-0">
                <a id="logout" class="btn w-100">Logout</a>
              </li>
            </ul>
          </button>
        <?php else: ?>
          <li class="list-group-item border-0 bg-body-tertiary p-0">
            <a href="/UTU-project/interfaz/public-html/register.html" class="btn btn-outline-success me-2">Register</a>
          </li>
          <li class="list-group-item border-0 bg-body-tertiary p-0">
            <a href="/UTU-project/interfaz/public-html/login.html" class="btn btn-outline-success me-2">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
</header>
<div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <?php if (isset($_SESSION['login'])): ?>
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel">Carrito de compras</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div>
        <section id="productsCarrito">

        </section>
      </div>
      <div class="d-flex justify-content-between align-items-center">
      <button type="button" class="btn btn-outline-success me-2" id="buyCart">Comprar</button>
      <select>
          <option value="">PickUp</option>
          <option value="">Delivery</option>
        </select>
      <p class="m-0" id="totalPrice">
      </p>

      </div>
    </div>
  <?php else: ?>
    <div class="d-flex flex-column justify-content-center align-items-center py-5">
            <div class="my-2">
            <h3>Sign in or sign up</h3>
                        <h3>to use the cart</h3>
            </div>
            <div>
                <a class="btn btn-outline-success" href="/UTU-project/interfaz/public-html/login.html">Sign in</a>
                <a class="btn btn-outline-success" href="/UTU-project/interfaz/public-html/register.html">Sign up</a>
            </div>
    </div>
  <?php endif; ?>
</div>


<?php if (isset($_SESSION['login'])): ?>
  
  
<?php endif; ?>