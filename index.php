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

<div id="main-carousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <?php
    if($logged == 'out'){
      echo '
    <li data-target="#main-carousel" data-slide-to="0" class="active"></li>
    <li data-target="#main-carousel" data-slide-to="1"></li>
    <li data-target="#main-carousel" data-slide-to="2"></li>
    ';
    }
    else{
      echo '
    <li data-target="#main-carousel" data-slide-to="0" class="active"></li>
    <li data-target="#main-carousel" data-slide-to="1"></li>
    ';
    }
    ?>

  </ol>
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <?php
    if($logged == 'out'){
      echo '
        <!-- Slide 1 -->
        <div class="item active">
          <div class="carousel-image-container">
            <img src="images/background_2.jpeg" class="img-responsive center-block carousel-image">
          </div>
          <div class="carousel-caption">
            <h1>Bienvenido a Muveo</h1>
            <h4>El portal de anuncios en español para profesionales autónomos.</h4>
            <p>¿No tienes cuenta?</p>
            <p>Registrate en tan sólo unos segundos.</p>
            <a class="btn btn-primary btn-lg" href="register.php">Registrarse</a>
          </div>
        </div>
      ';
    }
    ?>
    <!-- Slide 2 -->
    <div class="item <?php if($logged == 'in'){ echo 'active';}?>">
      <div class="carousel-image-container">
        <img src="images/background_3.jpg" class="img-responsive center-block carousel-image" style="opacity: 0.8">
      </div>
      <div class="carousel-caption">
        <h1>¿Qué buscas?</h1>
        <h4>Busca y contrata un profesor particular, un abogado o un diseñador de manera fácil y sencilla</h4>
        <!-- INI: Search Bar-->
        <div id="SearchBar">
          <div id="custom-search-input">
            <div class="input-group">
              <form method="post" action="busqueda.php">
                <input type="text" name="busqueda" class="form-control input-sm" placeholder="Busca sobre la temática en la que estes interesado."/>
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                      <i class="glyphicon glyphicon-search"></i>
                    </button>
                  </span>
              </form>
            </div>
          </div>
        </div>
        <h5>O si lo prefieres, busca entre todas la ofertas</h5>
        <a class="btn btn-info btn-lg" href=busqueda.php>Todas las ofertas</a>
        <!-- FIN: Search Bar-->
      </div>
    </div>
    <!-- Slide 3 -->
    <div class="item">
      <div class="carousel-image-container">
        <img src="images/business-handshake.jpg" class="img-responsive center-block carousel-image">
      </div>
      <div class="carousel-caption" style="text-align: left;">
        <?php
        if($logged == 'in'){
          if($_SESSION['tipo']== 0){
            echo '
            <h1>¿Eres un freelancer y buscas trabajo?</h1>
            <h4>Registrate como anunciante y crea tu oferta</h4>';
          }
          else{
            echo '<h1>¿Eres un freelancer? Crea un anuncio y encuentra clientes rapidamente</h1>
            <h4>Crea tu oferta aquí en tan sólo unos minutos</h4>
            <a class="btn btn-success" href="nueva_oferta.php">Crear anuncio</a>';
          }
        }
        else{
          echo '<h1>¿Eres un freelancer? Crea un anuncio y encuentra clientes rapidamente</h1>
          <h4>Crea tu oferta aquí en tan sólo unos minutos</h4>
          <a class="btn btn-success" data-toggle="modal" data-target="#loginModal">Crear anuncio</a>';
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
<div id="main-content" class="container">
  <h2 style="text-align: center">Comentarios de nuestros usuarios sobre Muveo</h2>
  <div class="row well" style="background-color: #ffffff">
    <div class="col-xs-6">
      <div class="media">
        <div class="media-left">
          <img class="media-object" src="images/doge_avatar.jpg" style="width: 64px; height: 64px;">
        </div>
        <div class="media-body">
          <h4 class="media-heading">Doge</h4>
          wow, very app. such skill.
          very A+ material
        </div>
      </div>
    </div>
    <div class="col-xs-6">
      <div class="media">
        <div class="media-body">
          <h4 class="media-heading">Elena Nito del Bosque</h4>
          Fantástica. Fácil, sencilla y muy útil para freelancers y personas que buscan soluciones rápidas.
        </div>
        <div class="media-right">
          <img class="media-object" src="images/avatar_test.jpg" style="width: 64px; height: 64px;">
        </div>
      </div>
    </div>
  </div>
  <p class="text-center text-inverse">© muveo.sytes.net 2015</p>
</div>
<!-- Modal para login -->
<?php
include 'modal.php';
?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script>
  $('.carousel').carousel({
    interval: 15000
  })
</script>
</body>
</html>