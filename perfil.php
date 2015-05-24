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

<div id="header">
    <!-- Header -->
    <?php include 'header.php'; ?>
</div>
<!-- Header End-->
<div class="container main-container">
    <h2>
        <?php
        if($user['nbUsuario']==$_SESSION['username']){
            echo 'Mi perfil';
        }
        else{
            printf("Perfil de %s %s",$user['nombre'],$user['apellidos']);
        }
        ?>
        <?php
        if($user['tipoUsuario']==0) {
            echo '<span class="tag" style="bottom: 10px; position: relative; background-color: #149bdf">Contratante</span>';
        }
        else{
            echo '<span class="tag" style="bottom: 10px; position: relative">Ofertante</span>';
        }
        ?>
    </h2>
    <hr>
    <div class="row">
        <aside class="col-md-3">
            <img id="avatar" src="<?php printf("%s",$user['avatarPath'])?>" class="img-responsive img-rounded">
            <?php
            if($user['nbUsuario']==$_SESSION['username']){
                printf("
                        <a href=\"editar_perfil.php\">
                            <button id=\"editar_preferencias\" class=\"btn btn-primary\">Editar perfil</button>
                        </a>
                        ");
                # glyphicon glyphicon-cog
            }
            ?>
        </aside>
        <div class="col-md-8" id="overview">
            <h4>Valoración: <span class="rating"><?php printf('%d',$user['valoracion'])?></span></h4>
            <div id="rating">
                <span class="valoracion val-<?php printf("%d",$user['valoracion'])?>"></span>
            </div>
            <h4>Nacionalidad:</h4>
            <?php
            printf("%s",$user['nacionalidad'])
            ?>
            <h4>Contacto:</h4>
            <ul>
                <?php
                printf("<li>Email: %s</li>",$user['email']);
                printf("<li>Teléfono: %s</li>",$user['telefono']);
                ?>
            </ul>
        </div>
    </div>
    <div class="row">
        <?php
        if($user['tipoUsuario']==1) {
            echo '<div class="col-lg-12" id="conocimientos"><h3>Habilidades y formación</h3><hr/>';
            echo '<p>';
            printf("%s",$user['formacion']);
            echo '</p>';
            echo '</div>';
        }
        ?>
        <div class="col-lg-12" id="ofertas">
            <?php
            if($user['tipoUsuario']==1){
                if($user['nbUsuario']==$_SESSION['username']){
                    printf("
                    <a href=\"nueva_oferta.php\">
                        <button class=\"btn btn-primary glyphicon glyphicon-plus-sign btn-add\"></button>
                    </a>
                    ");

                }
                echo '<h3>Ofertas realizadas</h3>';
            }
            else{
                echo '<h3>Ofertas contratadas</h3>';
            }
            ?>
            <hr/>
            <ul class="list-group" >
                <?php
                foreach($mysqli->query("SELECT * FROM Oferta WHERE idOfertante=".$user['idUsuario'])as $oferta) {
                    printf('<a href="oferta.php?id=%d"><li class="list-group-item">%s</li></a>', $oferta['idOferta'], $oferta['titulo']);
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<!-- Footer -->
<footer id="lema" class="">
    © muveo.sytes.net 2015
</footer>

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