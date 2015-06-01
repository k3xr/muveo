<?php
include_once 'php/db_connect.php';
include_once 'php/functions.php';

sec_session_start();

if(isset($_GET['id'])){
    $id=$_GET['id'];
}
$user = getUser($id,$mysqli);

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
<div class="container main-container well">
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
    <div class="row well" id="overview">
        <aside class="col-md-3" >
            <img id="avatar" src="<?php printf("%s",$user['avatarPath'])?>" class="img-responsive img-rounded">
            <?php
            if($user['nbUsuario']==$_SESSION['username']){
                printf("
                        <a href=\"editar_perfil.php\">
                            <button id=\"editar_preferencias\" class=\"btn btn-primary\">Editar perfil</button>
                        </a>
                        ");
            }
            ?>
        </aside>
        <div class="col-md-8">
            <h4>Nombre de usuario: </h4>
            <?php printf('%s',$user['nbUsuario'])?>
            <?php
            if($user['tipoUsuario']==1){
              echo'
            <h4>Valoración: <span class="rating">'.$user['valoracion'].'</span></h4>
            <div id="rating">
                <span class="valoracion val-'.($user['valoracion']*10).'"></span>
            </div>
            ';
            }
            ?>
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
            if($user['tipoUsuario']==1){//Ofertante
                if($user['nbUsuario']==$_SESSION['username']){
                    printf("
                    <a href=\"nueva_oferta.php\">
                        <button class=\"btn btn-primary btn-add\">Crear nueva oferta</button>
                    </a>
                    ");

                }
                echo '<h3>Ofertas realizadas</h3>';
            }
            else{//Contratante
                echo '<h3>Ofertas contratadas</h3>';
            }
            ?>
            <hr/>
              <div class="panel-group" id="acordeon" role="tablist" aria-multiselectable="true">
                <?php
                if($user['tipoUsuario']==1) {//Ofertante
                    $array = getOfertadas($user['idUsuario'], $mysqli);
                    $i = 0;
                    foreach ($array as $oferta) {
                      $datosOferta = getOferta($oferta['idOferta'], $mysqli);
                      echo
                      '
                      <div class="panel panel-default">
                      ';
                      printf('<div class="panel-heading" role="tab" id="heading%d">',$i);
                      echo '<h4 class="panel-title">';
                      printf('<a data-toggle="collapse"
                                  data-parent="#acordeon"
                                  href="#collapse%d"
                                  aria-expanded="false"
                                  aria-controls="collapse%d">
                                  %s</a>', $i,$i, $oferta['titulo']);
                      echo
                      '
                          </h4>
                          <label class="label label-info" id="categoria" for=""><span>'.$datosOferta['categoria'].'</span></label>
                        </div>

                      ';
                      printf('<div id="collapse%d" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading%d">',$i,$i);
                      echo
                      '
                        <div class="panel-body">
                        ';
                      printf('<h4>Descripción</h4><small>%s</small><br><br>',$oferta['descripcion']);
                      printf('<a class="btn btn-default" href="oferta.php?id=%d">Ver detalle</a>',$oferta['idOferta']);
                      if($user['idUsuario'] == $_SESSION['user_id']){
                        printf('<a class="btn btn-primary" href="editar_oferta.php?id=%d">Editar oferta</a>',$oferta['idOferta']);
                      }
                      echo
                      '
                        </div>
                      </div>
                      </div>
                      ';
                      $i++;
                    }
                }
                else{//Contratante
                    $array = getContratadas($user['idUsuario'], $mysqli);
                    foreach ($array as $oferta) {
                      $datosOferta = getOferta($oferta['idOferta'], $mysqli);
                      echo
                      '
                      <div class="panel panel-default">
                      ';
                      printf('<div class="panel-heading" role="tab" id="heading%d">',$i);
                      echo '<h4 class="panel-title">';
                      printf('<a data-toggle="collapse"
                                  data-parent="#acordeon"
                                  href="#collapse%d"
                                  aria-expanded="false"
                                  aria-controls="collapse%d">
                                  %s</a>', $i,$i, $oferta['titulo']);
                      echo
                      '
                          </h4>
                          <label class="label label-info" id="categoria" for=""><span>'.$datosOferta['categoria'].'</span></label>
                        </div>

                      ';
                      printf('<div id="collapse%d" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading%d">',$i,$i);
                      echo
                      '
                        <div class="panel-body">
                        ';
                      printf('<h4>Descripción</h4><small>%s</small><br><br>',$oferta['descripcion']);
                      printf('<a class="btn btn-default" href="oferta.php?id=%d">Ver detalle</a>', $oferta['idOferta']);
                      echo
                      '
                        </div>
                      </div>
                      </div>
                      ';
                      $i++;
                    }
                }
                ?>
              </div>
        </div>
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