<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="profile.css">
    <title>Perfil Clap</title>
</head>
<body>
    <?php
    session_start();
    include_once '/xampp/htdocs/UTU-project/logica/functions.php';
    loginValidator();
    ?>
    <?php
        include 'header.php';
    ?>
    <div id="separator"></div>

    <section class="container">
        <article class="card">
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item active" href="#account-general">General</a>
                        <a class="list-group-item" href="#account-change-password">Change password</a>
                        <a class="list-group-item" href="#account-info">Info</a>
                        <a class="list-group-item" href="#account-connections">Connections</a>
                        <a class="list-group-item" href="#account-notifications">Notifications</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane active" id="account-general">
                            <div class="media">
                                <img src="https://via.placeholder.com/150" alt="User Avatar" class="mr-3" id="user-avatar">
                                <div class="media-body">
                                    <label class="btn btn-outline-primary">
                                        Upload image
                                        <input type="file" id="file-input" style="display: none;">
                                    </label>
                                    <button type="button" class="btn btn-default">Reset</button>
                                    <div class="text-muted small mt-2">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                </div>
                            </div>
                            <hr>
                            <div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" id="username" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="company">Company</label>
                                    <input type="text" id="company" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <div class="text-right mt-3">
            <button type="button" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary">Cancel</button>
        </div>
    </section>
    <footer>
        <div>
            <ul>
                <li><img src="../src/img/svgs/brand-x.svg" alt=""><a href=""></a></img></li>
                <li><img src="../src/img/svgs/brand-youtube.svg" alt=""><a href=""></a></img></li>
                <li><img src="../src/img/svgs/brand-facebook.svg" alt=""><a href=""></a></img></li>
                <li><img src="../src/img/svgs/brand-instagram.svg" alt=""><a href=""></a></img></li>
            </ul>
            <ul>
                <li><a href="#" target="_blank">Term of service and use</a></li>
                <li><a href="#" target="_blank">How we take care of your privacity</a></li>
                <li><a href="#" target="_blank">Contact</a></li>
            </ul>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/profile.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/finder.js"></script>
    <script src="/UTU-project/interfaz/src/scripts/logout.js"></script>
</body>
</html>