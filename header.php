<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 09/05/2015
 * Time: 17:49
 */
echo '<div class="navbar navbar-default navbar-fixed-top" style="background-color: #ffffff">';

?>

<?php
if (isset($_GET['error'])) {
    echo '<div class="alert alert-danger text-center v-center" role="alert">Nombre de usuario o
        password incorrectos</div>';
}
?>

<?php

include_once 'php/functions.php';

if(!login_check($mysqli)) {
    echo '<div class="container">
    <div class="navbar-header">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
<span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php"><img src="images/icon_white.png"></a>
    </div>

    <div class="navbar-collapse collapse" id="navbar-main">
        <form class="navbar-form navbar-right" role="search" action="php/process_login.php" method="post" name="login_form">
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Usuario">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Contraseña">
            </div>
            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
        </form>
    </div>
</div>
</div>';
}else{
    echo '<div class="container">
    <div class="navbar-header">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
<span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php"><img src="images/logo.png"></a>
    </div>

    <div class="navbar-collapse collapse" id="navbar-main">
        <ul class="nav navbar-nav pull-right"  id="boton-sesion">
             <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                '.$_SESSION['username'].'
                <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">Perfil</a></li>
                    <li><a href="php/process_logout.php">Log out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</div>';
}

?>