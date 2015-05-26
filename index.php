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

<div id="main-carousel" class="carousel slide" data-ride="carousel" style="width: 100%; height: 500px; margin: 0 auto; box-shadow: 1px 1px 2px #222;;">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#main-carousel" data-slide-to="0" class="active"></li>
    <li data-target="#main-carousel" data-slide-to="1"></li>
    <li data-target="#main-carousel" data-slide-to="2"></li>
  </ol>
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
     <div style="width: 100%; height: 500px;">
      <img src="images/backgroundIndex.jpg" class="img-responsive center-block" style="position: absolute; opacity: .9">
     </div>
      <div class="carousel-caption" style="height: 70%;">
      <h1>Bienvenido a Muveo</h1>
      <h4>¿No tienes cuenta?</h4>
      <h4> Registrate en tan sólo unos segundos.</h4><br>
      <a class="btn btn-primary" href="register.php">Registrarse</a>
      </div>
    </div>
    <div class="item">
     <div style="width: 100%; height: 500px;">
      <img src="images/background_3.jpg" class="img-responsive center-block" style="position: absolute; opacity: .9">
     </div>
      <div class="carousel-caption" style="height: 70%;">
      <h1>¿Qué buscas?</h1>
      <h4>Busca tu profesor particular, abogado o diseñador de manera fácil y sencilla</h4>
                <!-- INI: Search Bar-->
                <div id="SearchBar">
                        <div id="custom-search-input" style="width: 100%;">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Busca sobre la temática que quieras"/>
                                <span class="input-group-btn">
                                    <form method="post" action="busqueda.php">
                                        <button class="btn btn-info" type="submit">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </button>
                                    </form>
                                </span>
                            </div>
                        </div>
                </div>
                <h5>O si lo prefieres, busca entre todas la ofertas</h5>
                <a class="btn btn-info" href=busqueda.php>Todas las ofertas</a>
            <!-- FIN: Search Bar-->
      </div>
    </div>
    <div class="item">
     <div style="width: 100%; height: 500px;">
      <img src="images/background_2.jpeg" class="img-responsive center-block" style="position: absolute; opacity: .9">
     </div>
      <div class="carousel-caption" style="height: 70%; text-align: left;">
      <h1>¿Eres un freelancer? Crea un anuncio y encuentra clientes rapidamente</h1>
      <h3>¡Inicia sesión y crea tu oferta!</h3>
          <?php
          if($logged == 'in'){
              echo '<a class="btn btn-success" href="nueva_oferta.php">Crear anuncio</a>';
          }
          else {
              echo '<a class="btn btn-success" data-toggle="modal" data-target="#loginModal">Crear anuncio</a>';
          }
          ?>
      </div>
    </div>
  </div>
  <!-- Controls -->
  <a class="left carousel-control" href="#main-carousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#main-carousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<!--
<div class="container" style="text-align: center; margin-top: 30px;">
    <div class="row">
        <div class="col-md-6">
            <img class="img-responsive" src="images/freelance.jpg" style="max-height: 400px; max-width: 400px; border-radius: 5px; margin: 0 auto;">
        </div>
        <div class="col-md-6">
            <img class="img-responsive" src="images/freelance.jpg" style="max-height: 400px; max-width: 400px; border-radius: 5px; margin: 0 auto;">
        </div>
    </div>
</div>
<div class="container" style="text-align: center; margin-top: 30px;">
    <div class="row">
        <div class="col-md-6">
            Texto
        </div>
        <div class="col-md-6">
            Texto
        </div>
    </div>
</div>
->
<!-- <div id="lema">¡Tus clases al mejor precio y cerca de tu casa!</div> -->
<div class="container" style="position: absolute; bottom: 0; text-align: center; width: 100%; color: white;">
    <div class="row">
        <div class="col-sm-offset-3 col-sm-6">
            <p class="text-center text-inverse">© muveo.sytes.net 2015</p>
        </div>
    </div>
</div>

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
                            <input type="text" name="username" class="form-control" placeholder="Usuario">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-xs-4 control-label"> Contraseña </label>
                        <div class="col-xs-6">
                            <input type="password" name="password" class="form-control" placeholder="Contraseña">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" value="Login" onclick="formhash(this.form, this.form.password);">
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
    $('.carousel').carousel({
      interval: 15000
    })
/*    $("#clases").click(function() {
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
    });*/
</script><!-- FIN: slideUP-->
</body>
</html>