<?php
include_once 'php/register.inc.php';
include_once 'php/functions.php';
?>

<!DOCTYPE html>
<html>

<head>
    <?php include 'head.php'; ?>
    <link href="css/registro.css" rel="stylesheet">
    <title>Muveo - Registro</title>

    <script type="text/JavaScript" src="js/sha512.js"></script>
    <script type="text/JavaScript" src="js/forms.js"></script>
</head>

<body>

<?php
if (!empty($error_msg)) {
    echo $error_msg;
}
?>
<!-- Header -->
<?php include 'header.php'; ?>
<!-- Header End-->
        <div class="container main-container">
            <div class="row">
                <section>
                    <h2><strong>Registrar una cuenta</strong></h2>
                    <hr>
                    <form class="form-horizontal" role="form" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="registration_form">
                        <h4>1. Datos de usuario</h4>
                        <div class="form-group">
                            <label for="Nombre" class="col-sm-2 control-label">Nombre de usuario</label>
                            <div class="col-sm-4">
                                <input type='text' name='username' id='username' class="form-control input-sm" placeholder="Nombre de usuario"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tipo" class="col-sm-2 control-label">Tipo de usuario</label>
                            <div id="tipo" class="col-sm-6">
                                <input type="radio" name="tipo" id="tipo-Cont" value="Contratante" checked> Contratante
                                <br>
                                <input type="radio" name="tipo" id="tipo-Ofer" value="Ofertante"> Ofertante
                            </div>
                        </div>
                        <hr>
                        <h4>2. Datos personales</h4>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Nombre</label>
                            <div class="col-sm-4">
                                <input type='text' name='nombre' id='nombre' class="form-control input-sm" placeholder="Nombre"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Apellidos" class="col-sm-2 control-label">Apellidos</label>
                            <div class="col-sm-4">
                                <input type='text' name='apellidos' id="apellidos" class="col-sm-6 form-control input-sm" placeholder="Apellidos">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">E-mail</label>
                            <div class="col-sm-4">
                                <input type="email" name="email" id="email" class="col-sm-6 form-control input-sm" placeholder="email@example.com"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tlf" class="col-sm-2 control-label">Teléfono</label>
                            <div class="col-sm-2">
                                <input type="tel" name="tlf" id="tlf" class="form-control input-sm" placeholder="Numero">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pais" class="col-sm-2 control-label">País</label>
                            <div class="col-sm-4">
                                <select id="pais" name="pais" class="form-control input-sm">
                                    <?php
                                    getPaises('Spain');
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Pass" class="col-sm-2 control-label">Contraseña</label>
                            <div class="col-sm-4">
                                <input type="password" name="password" id="password" class="form-control input-sm" placeholder="Contraseña">
                            </div>
                            <label id="passTooltip" style="display: none">La contraseña debe tener al menos 6 caracteres, 1 mayúscula y 1 número</label>
                        </div>
                        <div class="form-group">
                            <label for="Conf-Pass" class="col-sm-2 control-label">Repetir contraseña</label>
                            <div class="col-sm-4">
                                <input type="password" name="confirmpwd" id="confirmpwd" class="form-control input-sm" placeholder="Repetir contraseña">
                            </div>
                        </div>
                        <hr>
                        <input type="button"
                               id="boton-registro"
                               value="Crear cuenta"
                               class="btn btn-primary"
                               onclick="return regformhash(this.form,
                                                   this.form.username,
                                                   this.form.email,
                                                   this.form.password,
                                                   this.form.confirmpwd);" />
                    </form>
                </section>
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
<script>
    $('#password').focus(function() {
        $("#passTooltip").slideToggle("slow");
    });
    /*
     $('#password').attr("data-toggle","tooltip");
     $('#password').attr("data-placement","right");
     $('#password').attr("title","La contraseña debe tener al menos 6 caracteres, 1 mayúscula y 1 número");
     */
    $('#password').blur(function(){
        $("#passTooltip").slideToggle("slow");
    });
</script>

</body>

</html>