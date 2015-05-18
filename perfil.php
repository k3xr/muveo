<?php
include_once 'php/db_connect.php';
include_once 'php/functions.php';

sec_session_start();

if(isset($_GET['id'])){
    $id=$_GET['id'];
}
foreach($mysqli->query("SELECT * FROM Usuario WHERE idUsuario=\"".$id."\"")as $user);

?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'head.php'; ?>
    <link href="css/perfil.css" rel="stylesheet">
    <title>Muveo - Perfil</title>
</head>

<body>

<div id="container">
    <div id="header">
        <!-- Header -->
        <?php include 'header.php'; ?>
    </div>
    <!-- Header End-->

<div id="body">
    <div class="container" id="container-default">
        <div class="row" id="info-pral">
            <div class="col-md-4">
                <?php
                printf("
                <img id=\"avatar\" src=\"%s\" class=\"img-responsive img-rounded\">
                ", $user['avatarPath']);

                printf("
                 <span class=\"valoracion val-%d\"></span>
                ", $user['valoracion']);
                ?>

            </div>
            <div class="col-md-8">
                <h2>
                    <?php
                    printf("%s %s",$user['nombre'],$user['apellidos']);
                    ?>
                </h2>
                    <?php
                    if($user['nbUsuario']==$_SESSION['username']){
                        printf("
                        <a href=\"editar_perfil.php\">
                            <button class=\"btn btn-default glyphicon glyphicon-cog\"></button>
                        </a>
                        ");
                    }
                    ?>
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
                <h2>Formación</h2>
                <hr/>
                <p>
                    <?php
                    printf("%s",$user['formacion']);
                    ?>
                </p>
            </div>

            <div class="col-md-5" id="ofertas">
                <?php
                if($user['nbUsuario']==$_SESSION['username']){
                    printf("
                    <a href=\"nueva_oferta.php\">
                        <button class=\"btn btn-default glyphicon glyphicon-plus-sign btn-add\"></button>
                    </a>
                    ");
                }
                ?>

                <h1>Ofertas</h1>
                <hr/>
                <ul class="list-group" >
                    <?php
                    foreach($mysqli->query("SELECT * FROM Oferta WHERE idOfertante=".$user['idUsuario'])as $oferta){
                        printf("
                    <a href=\"oferta.php\">
                        <li class=\"list-group-item\">
                        %s
                        </li>
                    </a>
                    ",$oferta['titulo']);
                    }
                    ?>
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