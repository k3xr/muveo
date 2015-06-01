<?php
if (isset($_GET['error'])) {
  echo '<div class="container" style="position: absolute; left: 50%">
<div id="loginFail" class="alert alert-danger alert-dismissible text-center v-center" role="alert">Nombre de usuario o
        password incorrectos
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></div></div>';
}