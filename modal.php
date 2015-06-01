<?php
echo '<!-- Modal para login -->
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
      <form action="php/process_login.php" class="form-horizontal" method="post" name="login_form">
      <div class="modal-body">
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
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" value="Login" onclick="formhash(this.form, this.form.password);">
          Iniciar sesión
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
          Cerrar
        </button>
      </div>
      </form>
    </div>
  </div>
</div>';