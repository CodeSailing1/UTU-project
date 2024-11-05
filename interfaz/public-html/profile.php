<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="profile.css">

    <title>Perfil Clap</title>
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['login'])) {
        header("location: /UTU-project/interfaz/public-html/index.php");
        session_destroy();
    }
    include 'header.php';
    ?>

    <main class="d-flex justify-content-center w-100">
        <section class="col-md-6 d-flex flex-column align-items-center" id="showData">
            <div class="bg-body-secondary p-5 d-flex justify-content-center align-items-center overflow-hidden position-relative"
                style="width: 100px; height: 100px; border-radius: 50%;">
                <img src="/UTU-project/persistencia/assets/<?php echo $_SESSION['imagenUsuario']; ?>" alt="" height="100" id="svg">
            </div>
            <hr style="width:100%">
            <div class="container w-75 d-flex flex-column">
                <div class="d-flex flex-column align-items-center">
                    <label for="username">Name:</label>
                    <p id="name" class="px-5 border rounded w-50 text-center"> <?php echo $_SESSION['nombre'] ?></p>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <label for="email">Email:</label>
                    <p id="email" class="px-5 border rounded w-50 text-center"> <?php echo $_SESSION['email'] ?></p>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <label for="phone">Telefono:</label>
                    <p id="phone" class="px-5 border rounded w-50 text-center"> <?php echo $_SESSION['phone'] ?></p>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <label for="direction">Direccion:</label>
                    <p id="direction" class="px-5 border rounded w-50 text-center"> <?php echo $_SESSION['direction'] ?></p>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <button type="button" name="password" class="btn btn-outline-success w-50" style="height:39px" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Change password</button>
                </div>
            </div>
        </section>
    </main>

    <?php include 'footer.php' ?>
    <script type="module" src="/UTU-project/interfaz/src/scripts/usuario/profile.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/finder.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/udateURL.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/usuario/logout.js"></script>
    <script type="module" src="/UTU-project/interfaz/src/scripts/addProductCarrito.js"></script>
    <script type="module" src="/UTU-project/interfaz/src/scripts/removeProductCarrito.js"></script>
    <script type="module" src="/UTU-project/interfaz/src/scripts/showProductCarrito.js"></script>
    <script type="module" src="/UTU-project/interfaz/src/scripts/showTotalPriceCarrito.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/buyCart.js"></script>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered p-5">
            <div class="modal-content p-5">
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title" id="staticBackdropLabel">Cambio de contrasenia</h5>
                </div>
                <form action="" method="post" class="form-group row" name="formData" id="formData">
                    <label class="col-form-label">
                        Password
                        <input type="password" name="password" class="form-control input" id="pass">
                    </label>
                    <label class="col-form-label">
                        Password confirmation
                        <input type="password" name="confirmPassword" class="form-control input" id="conf">
                    </label>
                    <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">No</button>
                    <input type="submit" class="btn btn-secondary" id="submitButton" value="Si"disabled></input>
                </div>
                </form>
                
            </div>
        </div>
    </div>
</body>

</html>
