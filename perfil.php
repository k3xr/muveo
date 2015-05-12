<?php
include_once 'php/db_connect.php';
include_once 'php/functions.php';

sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}

foreach($mysqli->query("SELECT * FROM Usuario WHERE nbUsuario=".$_SESSION['username'])as $user);

?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'head.php'; ?>
    <link href="css/perfil.css" rel="stylesheet">
    <title>Muveo - Perfil</title>

    <script type="text/JavaScript" src="js/sha512.js"></script>
    <script type="text/JavaScript" src="js/forms.js"></script>
    <![endif]-->
</head>

<body>

<div id="container">
    <div id="header">
        <!-- Header -->

        <div class="navbar navbar-default navbar-fixed-top" style="background-color: #ffffff">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><img src="images/icon_white.png"></a>

                </div>

                <div class="navbar-collapse collapse" id="navbar-main">

                    <div>
                        <?php
                        if (login_check($mysqli) == true) {
                            echo "<p>Currently logged " . $logged . " as " . htmlentities($_SESSION['username']) . ". <a href='includes/logout.php'>Log out</a></p>";
                            printf("
                                <ul class=\"nav navbar-nav\" id=\"boton-sesion\">
                                    <li class=\"dropdown\">
                                        <a class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                                            %s
                                            <b class=\"caret\"></b>
                                        </a>
                                        <ul class=\"dropdown-menu\">
                                            <li><a href=\"#\">Perfil</a></li>
                                            <li><a href=\"#\">Log Out</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            ",$user['nbUsuario']);
                        } else {
                            //echo "<p>Currently logged " . $logged . ". <a href='register.php'>register</a></p>";
                            printf("
                                <form class=\"navbar-form navbar-right\" role=\"search\" action=\"php/process_login.php\" method=\"post\" name=\"login_form\">
                                    <div class=\"form-group\">
                                        <input type=\"text\" name=\"email\" class=\"form-control\" placeholder=\"Usuario\">
                                    </div>
                                    <div class=\"form-group\">
                                        <input type=\"password\" name=\"password\" class=\"form-control\" placeholder=\"Contraseña\">
                                    </div>
                                    <button type=\"submit\" class=\"btn btn-primary\" value=\"Login\" onclick=\"formhash(this.form, this.form.password);\">Iniciar sesión</button>
                                </form>
                            ");
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End-->

<div id="body">
    <div class="container" id="container-default">
        <div class="row" id="info-pral">
            <div class="col-md-4">
                <img id="avatar" src="http://www.jornalq.com/images/Artigos2014D/chooeffd.jpg" class="img-responsive img-rounded">
                <span class="valoracion val-50"></span>
            </div>
            <div class="col-md-8">
                <h2>
                    <?php
                    printf("%s %s",$user['nombre'],$user['apellidos']);
                    ?>
                </h2>
                <a href="editar_perfil.php">
                    <button class="btn btn-default glyphicon glyphicon-cog"></button>
                </a>
                <h4>
                    <?php
                    printf("%s",$user['nacionalidad'])
                    ?>
                </h4>
                <h4>
                    <?php
                    printf("%s",$user['email']);
                    ?>

                </h4>
            </div>
        </div>
        <div class="row">

            <div class="col-md-5" id="conocimientos">
                <button class="btn btn-default glyphicon glyphicon-plus-sign btn-add"></button>
                <h2>Conocimientos</h2>
                <hr/>
                <h4>
                    <?php $user['formacion'] ?>
                </h4>
            </div>

            <div class="col-md-5" id="ofertas">
                <a href="nueva_oferta.php">
                    <button class="btn btn-default glyphicon glyphicon-plus-sign btn-add"></button>
                </a>
                <h1>Ofertas</h1>
                <hr/>
                <ul class="list-group" >
                    <a href="oferta.php">
                        <li class="list-group-item">
                            Clase de Artes Marciales
                        </li>
                    </a>
                    <a href="#">
                        <li class="list-group-item">
                            Charla en conferencias
                        </li>
                    </a>
                    <a href="#">
                        <li class="list-group-item">
                            Actuación en películas
                        </li>
                    </a>
                    <a href="#">
                        <li class="list-group-item">
                            Actuación en anuncios
                        </li>
                    </a>
                </ul>
            </div>
        </div>
    </div>

</div>
<div id="footer">
    <!-- Footer -->
    <footer id="lema" class="">
        © muveo.sytes.net 2015
    </footer>
</div>
</div>



<!-- Modal para login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3>Inicia sesión para continuar</h3>
                <h5>¿No tienes cuenta? ¡Registrate <a href=""> aquí</a> en menos de un minuto!</h5>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="inputUsername" class="col-xs-4 control-label"> Nombre de usuario </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" id="inputUsername" placeholder="Usuario">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="col-xs-4 control-label"> Contraseña </label>
                        <div class="col-xs-6">
                            <input type="password" class="form-control" id="inputPassword" placeholder="Contraseña">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">
                    Iniciar sesión
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal para login -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>