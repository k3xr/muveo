<?php

echo '<div class="navbar navbar-default navbar-fixed-top" style="background-color: #ffffff">';

?>

<?php
if (isset($_GET['error'])) {
    echo '<div class="alert alert-danger text-center v-center" role="alert">Nombre de usuario o
        password incorrectos</div>';
}

include_once 'php/functions.php';

echo '<div class="container">
    <div class="navbar-header">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <link rel="shortcut icon" href="images/muveo_icon_black.png">
        <a class="navbar-brand" href="index.php"><img src="images/muveo_logo_black.png"></a>
    </div>
    <div class="navbar-collapse collapse" id="navbar-main">
        <form method="post" action="busqueda.php" class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" name="busqueda" class="form-control input-sm" placeholder="Buscar"/>
        </div>
            <button class="btn btn-default" type="submit">Explorar</button>
        </form>';

if (!login_check($mysqli)) {

    echo'
        <script type="text/JavaScript" src="js/sha512.js"></script>
        <script type="text/JavaScript" src="js/forms.js"></script>
        <form class="navbar-form navbar-right" role="search" action="php/process_login.php" method="post" name="login_form">
            <div class="form-group">
                <input type="text" name="username" class="form-control input-sm" placeholder="Usuario">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control input-sm" placeholder="Contraseña">
            </div>
            <button type="submit" class="btn btn-default" value="Login" onclick="formhash(this.form, this.form.password);">Iniciar sesión</button>
        </form>
    </div>
</div>
</div>';
} else {
    echo '
        <ul class="nav navbar-nav pull-right"  id="boton-sesion">
             <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding: 10px 5px 0px 5px">
                <img class="avatar_perfil" src="'.$_SESSION['avatar'].'"/>
                ' . $_SESSION['username'] . '
                <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="perfil.php?id=' . $_SESSION['user_id'] . '">Perfil</a></li>
                    <li><a href="php/process_logout.php">Log out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</div>';
}

?>