<?php

include_once 'php/db_connect.php';
include_once 'php/editar_perfil.inc.php';
include_once 'php/functions.php';

sec_session_start();

if(!$_SESSION['user_id']>0) {
    header('Location: ../error.php');
}

$user = getUser($_SESSION['user_id'],$mysqli);

?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'head.php'; ?>
    <link href="css/editar_perfil.css" rel="stylesheet">
    <title>Muveo</title>

    <script type="text/JavaScript" src="js/sha512.js"></script>
    <script type="text/JavaScript" src="js/forms.js"></script>
</head>

<body>

<!-- Header -->
<?php include 'header.php'; ?>
<!-- Header End-->
<div class="container main-container">
    <div class="row">
        <h2><strong>Editar perfil</strong></h2>
        <hr>
        <section class="col-lg-12">
            <form class="form-horizontal" enctype="multipart/form-data" role="form" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post">
                <h4>1. Datos personales </h4>
                <div class="form-group">
                    <label for="Nombre" class="col-sm-2 control-label">Nombre</label>
                    <div class="col-sm-4">
                        <input id="Nombre" name="username" class="form-control input-sm" value="<?php echo($user['nombre']);?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="Apellidos" class="col-sm-2 control-label">Apellidos</label>
                    <div class="col-sm-4">
                        <input id="Apellidos" name="apellidos" class="form-control input-sm" value="<?php echo($user['apellidos']);?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">E-mail</label>
                    <div class="col-sm-4">
                        <input type="email" id="Email" name="email" class="form-control input-sm" value="<?php echo($user['email']);?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tlf" class="col-sm-2 control-label">Teléfono</label>
                    <div class="col-sm-2">
                        <input type="tel" id="tlf" name="tlf" class="form-control input-sm" value="<?php echo($user['telefono']);?>">
                    </div>
                </div>
                <!-- Location -->
                <div class="form-group">
                    <label for="pais" class="col-sm-2 control-label">País</label>
                    <div class="col-sm-4">
                        <select id="pais" name="pais" class="form-control input-sm">
                            <?php
                                getPaises($user['nacionalidad']);
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <?php
                    if($user['tipoUsuario']==1) {//Ofertante
                        echo'                <div class="form-group">
                    <label for="formacion" class="col-sm-2 control-label">Formación</label>
                    <div class="col-sm-8">
                        <textarea id="formacion" name="formacion" class="col-sm-6 form-control" rows="8" placeholder="Añade aquí tus conocimientos y habilidades.">'.$user['formacion'].'</textarea>
                    </div>
                </div>';
                    }
                ?>

                <!-- Imagen -->
                <div class="form-group">
                    <label for="Avatar" class="col-sm-2 control-label">Imagen de perfil</label>
                    <div class="col-sm-2">
                        <?php
                            echo('<img id=show-avatar src="'.$user['avatarPath'].'" class="img-responsive img-rounded">');
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6">
                        <input type="file" id="Avatar" name="avatar">
                        <p class="help-block">Añade una imagen de portada para tu perfil. Tamaño máximo 720 x 720. Archivos soportados: <strong>.jpg, .jpge, .gif, .png</strong></p>
                    </div>
                </div>
                <hr>
                <h4>2. Cambiar contraseña </h4>
                <!-- Modificar Password {-->
                <div class="form-group">
                    <label for="Pass-old" class="col-sm-2 control-label">Contraseña antigua</label>
                    <div class="col-sm-4">
                        <input type="password" id="Pass-old" name="old_Pass" class="form-control tip input-sm">
                    </div>
                </div>
                <div class="form-group">
                    <label for="Pass" class="col-sm-2 control-label">Nueva contraseña</label>
                    <div class="col-sm-4">
                        <input type="password" id="Pass" name="password" class="form-control input-sm">
                    </div>
                </div>
                <div class="form-group">
                    <label for="Conf-Pass" class="col-sm-2 control-label">Confirmar contraseña</label>
                    <div class="col-sm-4">
                        <input type="password" id="Conf-Pass" name="conf" class="form-control input-sm">
                    </div>
                </div>
                <hr>
                <button type="button"
                       id="create"
                       value="Guardar"
                       class="btn btn-primary"
                       onclick="return regformhash2(this.form,
                                                   this.form.password,
                                                   this.form.conf);" />Guardar</button>
                <button id="back" type="button" class="btn btn-primary" onclick="history.back();">Volver</button>
            </form>
        </section>
    </div>
</div>



<!-- Modal para login -->
<?php
include 'modal.php';
?>
<!-- Modal para login -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>