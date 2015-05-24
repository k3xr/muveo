<?php
include_once 'php/db_connect.php';
include_once 'php/functions.php';

sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'head.php'; ?>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <title>Muveo</title>
</head>

<body>
<!-- Header -->
<?php include 'header.php'; ?>
<!-- Header End-->

<div class="container" id="container-full">
    <div class="row">
        <div class="col-lg-12" id="PanelInicio">
            <h1 class="text-inverse">¿Qué buscas?</h1>

            <p class="text-inverse">Busca tu profesor particular o encuentra tu trabajo ideal</p>

            <div class="row">
                <div class="col-md-offset-3 col-md-3">
                    <button class="btn btn-primary" id="clases">Ofertas</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary" id="trabajo" data-toggle="modal" data-target="#loginModal">Trabajo
                    </button>
                </div>

                <!-- INI: Search Bar-->
                <div class="container" id="SearchBar">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <div id="custom-search-input">

                                    <form method="post" action="busqueda.php">
                                        <div class="input-group">
                                        <input type="text" class="form-control" name="busqueda" placeholder="Buscar"/>
                                            <span class="input-group-btn">
                                                    <button class="btn btn-primary" type="submit">
                                                        <i class="glyphicon glyphicon-search"></i>
                                                    </button>
                                            </span>
                                        </div>
                                    </form>

                            </div>
                        </div>
                    </div>
                    <!--INI: Boton Atras-->
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <button class="btn btn-primary" type="button" id="botonAtras" style="margin-top: 10px;">
                                Atrás
                            </button>
                        </div>
                    </div>
                    <!--FIN: Boton Atras-->
                </div>
                <!-- FIN: Search Bar-->
            </div>
            <br>
            <br>
        </div>
    </div>
</div>

<!-- <div id="lema">¡Tus clases al mejor precio y cerca de tu casa!</div> -->
<div class="container" style="position: absolute; bottom: 0; text-align: center; width: 100%; color: white;">
    <div class="row">
        <div class="col-sm-offset-3 col-sm-6">
            <p class="text-center text-inverse">© muveo.sytes.net 2015</p>
        </div>
    </div>
</div>

<!-- Modal para login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myLoginModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aira-hidden="true">
                    &times;
                </button>
                <h3>Inicia sesión para continuar</h3>
                <h5>¿No tienes cuenta? ¡Registrate <a href="register.php"> aquí</a> en menos de un minuto!</h5>
            </div>

            <div class="modal-body">
                <form action="php/process_login.php" class="form-horizontal" method="post" name="login_form">
                    <div class="form-group">
                        <label for="inputUsername" class="col-xs-4 control-label"> Nombre de usuario </label>

                        <div class="col-xs-6">
                            <input type="text" name="username" class="form-control" placeholder="Usuario">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-xs-4 control-label"> Contraseña </label>

                        <div class="col-xs-6">
                            <input type="password" name="password" class="form-control" placeholder="Contraseña">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" value="Login"
                            onclick="formhash(this.form, this.form.password);">
                        Iniciar sesión
                    </button>
                </form>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<!-- INI: slideUP-->
<script>
    $("#clases").click(function () {
        $("#clases").hide(400);
        $("#trabajo").hide(400, function () {
            document.getElementById("SearchBar").style.visibility = "visible";
        });
    });
    $("#botonAtras").click(function () {
        $("#clases").show(400);
        $("#trabajo").show(400);
        document.getElementById("SearchBar").style.visibility = "hidden";
    });
</script>
<!-- FIN: slideUP-->
</body>
</html>