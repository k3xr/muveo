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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="ofertas de clases"/>
    <meta charset="keywords" content="clases"/>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <!--Estilos-->
    <link rel="stylesheet" href="css/estilos.css">

    <title>Muveo</title>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <script type="text/JavaScript" src="js/sha512.js"></script>
    <script type="text/JavaScript" src="js/forms.js"></script>
    <![endif]-->
</head>

<body>
<?php
if (isset($_GET['error'])) {
    echo '<p class="error">Error Logging In!</p>';
}
?>

<div class="navbar navbar-default navbar-fixed-top" style="background-color: #ffffff">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://muveo.sytes.net/"><img src="images/icon_white.png"></img> </a>

        </div>

        <div class="navbar-collapse collapse" id="navbar-main">
            <div>
                <?php
                if (login_check($mysqli) == true) {
                    echo "<p>Currently logged " . $logged . " as " . htmlentities($_SESSION['username']) . ". <a href='includes/logout.php'>Log out</a></p>";
                } else {
                    //echo "<p>Currently logged " . $logged . ". <a href='register.php'>register</a></p>";
                }
                ?>
            </div>

            <form class="navbar-form navbar-right" role="search" action="php/process_login.php" method="post" name="login_form">
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="Usuario">
                </div>
                <div class="form-group">
                    <input type="text" name="password" class="form-control" placeholder="Contraseña">
                </div>
                <button type="submit" class="btn btn-primary" value="Login" onclick="formhash(this.form, this.form.password);">Iniciar sesión</button>
            </form>

        </div>
    </div>
</div>

<div class="container-fluid" id="container-full">
    <div class="row">
        <div class="col-lg-12 col-xs-12 text-center v-center" id="PanelInicio">

            <h1 class="text-inverse">¿Qué buscas?</h1>
            <p class="text-inverse">Busca tu profesor particular o encuentra tu trabajo ideal</p>
            <div class="row">
                <div class="col-md-offset-3 col-md-3 col-xs-12 v-center">
                    <button class="btn btn-lg btn-primary" id="clases">Clases</button>
                </div>
                <div class="col-md-3 col-xs-12 v-center">
                    <button class="btn btn-lg btn-primary" id="trabajo" data-toggle="modal" data-target="#loginModal">Trabajo</button>
                </div>

                <!-- INI: Search Bar-->
                <div class="container" id="SearchBar">
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <div id="custom-search-input">
                                <div class="input-group col-md-12">
                                    <input type="text" class="form-control input-lg" placeholder="Buscar" />
                                            <span class="input-group-btn">
                                                <form method="post" action="busqueda.html">
                                                    <button class="btn btn-info btn-lg" type="submit">
                                                        <i class="glyphicon glyphicon-search"></i>
                                                    </button>
                                                </form>
                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--INI: Boton Atras-->
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <button class="btn btn-lg btn-primary" type="button" id="botonAtras" style="margin-top: 10px;">Atrás</button>
                        </div>
                    </div>
                    <!--FIN: Boton Atras-->
                </div>
                <!-- FIN: Search Bar-->
                <!-- Modal para login -->
                <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myLoginModalLabel" aria-hidden="true">
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
                                            <input type="text" name="email" class="form-control" id="inputUsername" placeholder="Usuario">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-xs-4 control-label"> Contraseña </label>
                                        <div class="col-xs-6">
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" value="Login" onclick="formhash(this.form, this.form.password);">
                                    Iniciar sesión
                                </button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
        </div>
    </div>
</div>

<!-- <div id="lema">¡Tus clases al mejor precio y cerca de tu casa!</div> -->
<footer class="section">
    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <p class="text-center text-inverse">© Muveo.sytes.net 2015</p>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
</footer>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<!-- INI: slideUP-->
<script>
    $("#clases").click(function() {
        $( "#clases" ).hide(400);
        $( "#trabajo" ).hide(400, function()
        {
            document.getElementById("SearchBar").style.visibility = "visible";
        });
    });
    $("#botonAtras").click(function() {
        $( "#clases" ).show(400);
        $( "#trabajo" ).show(400);
        document.getElementById("SearchBar").style.visibility="hidden" ;
    });
</script><!-- FIN: slideUP-->
</body>
</html>