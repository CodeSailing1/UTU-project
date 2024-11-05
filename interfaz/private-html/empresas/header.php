<header class="w-100 ">
  <nav class=" navbar navbar-expand-lg bg-body-tertiary w-100 p-3 mb-3">
    <!-- Logo -->
    

    <!-- Botón de colapso para pantallas pequeñas -->

    <!-- Menú colapsable -->
    <a class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </a>
    <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">
    <a class="navbar-brand " href="/UTU-project/interfaz/public-html/index.php">
      <img src="/UTU-project/interfaz/src/img/Claptransparente.png" alt="Logo" class="logo" height="75">
    </a>

        <!-- Verificación de sesión -->
        <?php if (isset($_SESSION['loginEmpresa'])): ?>
          <button class="nav-item dropstart border-0 bg-transparent " type="button">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img class="navbar-brand rounded-5 object-fit-cover"
                src="/UTU-project/persistencia/assets/<?php echo $_SESSION['imagenEmpresa']; ?>" height="50" width="50">
            </a>
            <ul class="dropdown-menu z-3">
              <li class="dropdown-item border-0 bg-body-tertiary p-0">
                <a href="/UTU-project/interfaz/public-html/profile.php" class="btn w-100">Profile</a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>

              <li class="dropdown-item border-0 bg-body-tertiary p-0">
                <a id="logout" class="btn w-100">Logout</a>
              </li>
            </ul>
          </button>
        <?php else: ?>
          <ul class="d-flex">
          <li class="list-group-item border-0 bg-body-tertiary p-0">
            <a href="/UTU-project/interfaz/public-html/register.html" class="btn btn-outline-success me-2">Register</a>
          </li>
          <li class="list-group-item border-0 bg-body-tertiary p-0">
            <a href="/UTU-project/interfaz/public-html/login.html" class="btn btn-outline-success me-2">Login</a>
          </li>
          </ul>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
</header>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="./scripts/logout.js"></script>