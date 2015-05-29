<?php
include_once 'php/db_connect.php';
include_once 'php/functions.php';

sec_session_start();

if(isset($_GET['idOferta'])){
  $idOferta=$_GET['idOferta'];
}
if(isset($_GET['id'])){
    $id=$_GET['id'];
}

$oferta = getOferta($idOferta,$mysqli);
$user = getUser($id,$mysqli);

?>

<!DOCTYPE html>
<html>
<head>
  <?php include 'head.php'; ?>
  <link href="css/pasarela.css" rel="stylesheet">
  <title>Muveo - Contratación</title>
</head>
<body>
<!-- Header -->
<?php include 'header.php'; ?>
<!-- Header End-->

<!-- Source: Bootsnipp. Bootstrap 2.3.2 Snippet by msurguy-->
<div class="container main-container well">
  <h3>Contratación de oferta</h3>
  <div class="row">
    <div class="col-xs-8">
      <div class="panel panel-info">
        <div class="panel-heading">
          <div class="panel-title">
            <div class="row">
              <div class="col-xs-6">
                <h5><span class="glyphicon glyphicon-shopping-cart"></span><?php echo $user['nbUsuario'] ?></h5>
              </div>
              <div class="col-xs-6">
                <a href="busqueda.php" type="button" class="btn btn-primary btn-sm btn-block">
                  <span class="glyphicon glyphicon-share-alt"></span> Volver a ofertas
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-xs-2">
              <?php printf('<img id="portada" src="%s" class="img-responsive" style="max-width: 100px; max-height: 70px;">',$oferta['portadaPath']); ?>
            </div>
            <div class="col-xs-4">
              <h4 class="product-name"><strong><?php printf("%s",$oferta['titulo']);?></strong></h4>
              <h4><small><?php printf("%s",$oferta['categoria'])?></small></h4>
            </div>
          </div>
        </div>
        <div class="panel-footer">
          <div class="row text-center">
            <div class="col-xs-9">
              <h4 class="text-right">Total <strong><?php printf("%d &euro;",$oferta['precio'])?></strong></h4>
            </div>
            <div class="col-xs-3">
              <?php echo '<a href="/php/contratar.php?id='.$id.'&idOferta='.$idOferta.'" class="btn btn-success btn-block"><span class="glyphicon glyphicon-hand-right"></span>Contratar</a>' ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal para login -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
</body>
</html>