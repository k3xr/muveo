<?php

include_once 'php/db_connect.php';
include_once 'php/editar_oferta.inc.php';
include_once 'php/functions.php';

sec_session_start();

if(isset($_GET['id'])){
    $id=$_GET['id'];
}
$oferta = getOferta($id,$mysqli);
$user = getUser($oferta['idOfertante'],$mysqli);

?>

<!DOCTYPE html>
<html>

<head>
    <?php include 'head.php'; ?>
    <link href="css/editar_oferta.css" rel="stylesheet">
    <title>Muveo</title>

    <script type="text/JavaScript" src="js/sha512.js"></script>
    <script type="text/JavaScript" src="js/forms.js"></script>
</head>

<body>
<!-- Header -->
<?php include 'header.php'; ?>
<!-- Header End-->

<div class="container-fluid main-container well">
		<div class="row">
			<h2><strong>Editar oferta</strong></h2>
			<hr>
            <div id="overview" class="col-lg-3">
                    <h4><strong><?php //Titulo Oferta
                            printf("%s",$oferta['titulo']);
                        ?>
					</strong></h4>
                    <div>
                        <?php //Imagen Oferta
                            printf('<img id="portada" src="%s" class="img-responsive">',$oferta['portadaPath']);
                        ?>
                    </div>
                    <h5><strong>Anunciante</strong></h5>
                    <?php  //Nombre Ofertante
                    printf('<a href="perfil.php?id=%d"><h4><strong>'.$user['nombre'].' '.$user['apellidos'].'</strong></h4></a>', $user['idUsuario']);
					?>
					<div id="author">
            </div>
					
                    <h5><strong>Contacto</strong></h5>
                    <?php //Email Ofertante
                    printf('<a href="mailto:%s"><strong>'.$user['email'].'</strong></a>',$user['email']);
					?>
                    <span id="rating">
                        <?php //Valoracion oferta
                        printf('<span class="valoracion val-%d"></span>', $oferta['valoracion']*10);
						?>
                    </span>
                    <h5><strong>Temas relacionados</strong></h5>
            </div>
			<section class="col-md-8">
				<form class="form-horizontal" enctype="multipart/form-data" role="form" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post">
                    <h4>1. Información general</h4>
					<!-- Title -->
					<div class="form-group">
						<label for="titulo" class="col-sm-2 control-label">Titulo</label>
						<div class="col-sm-7">
							<input id="titulo" name="titulo" class="col-sm-4 form-control" placeholder="Titulo del anuncio" value="<?php echo($oferta['titulo']);?>" required>
						</div> 
					</div>
					<!-- Topic -->
					<div class="form-group">
						<label for="categoria" class="col-sm-2 control-label">Categoría</label>
						<div class="col-sm-7">
							<select id="categoria" name="categoria" class="col-sm-4 form-control">
                                <?php
                                getCategorias($oferta['categoria']);
                                ?>
							</select>
						</div>
					</div>
					<!-- Description -->
					<div class="form-group">
						<label for="descripcion" class="col-sm-2 control-label">Descripcion</label>
						<div class="col-sm-8">
							<textarea id="descripcion" name="descripcion" class="col-sm-6 form-control" rows="8" placeholder="Añade aquí la descripción del anuncio."><?php echo($oferta['descripcion']);?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="imagenOferta" class="col-sm-2 control-label">Portada</label>
						<div class="col-sm-8">
							<?php
                            echo('<img id=show-avatar src="'.$oferta['portadaPath'].'" class="img-responsive img-rounded" height="100" width="100">');
							?>
						    <input id="imagenOferta" type="file" name="imagenOferta"/>
						    <p class="help-block">Selecciona una nueva imagen de portada para tu anuncio. Tamaño máximo 720 x 720. Archivos soportados: <strong>.jpg, .jpeg, .gif, .png</strong></p>
						</div>
					</div>
					<hr>
                    <h4>2. Datos relevantes</h4>
					<!-- Price -->
					<div class="form-group">
						<div class="form-inline">
							<label for="precio" class="col-sm-2 control-label" required>
								Precio
							</label>
							<div class="col-sm-4">
								<input id="precio" type="text" name="precio" class="form-control" value="<?php echo($oferta['precio']);?>">
								&nbsp;€/hora
							</div>
						</div>
					</div>
					<!-- Languages -->
					<div class="form-group">
						<label class="col-sm-2 control-label">Idioma</label>
                            <div class="col-sm-2">
                                <input type="radio" name="idioma" value="es" checked> Español
                                <br>
                                <input type="radio" name="idioma" value="en" > Inglés
                                <br>
                                <input type="radio" name="idioma" value="ch" > Chino
                                <br>
                                <input type="radio" name="idioma" value="de" > Alemán
                                <br>
                                <input type="radio" name="idioma" value="fr" > Francés
                            </div>
					</div>
					<!-- Location -->
					<div class="form-group">
						<label class="col-sm-2 control-label">Provincia</label>
						<div class="col-sm-3">
							<select name="provincia" class="form-control" required>
                                <?php
                                    getProvincias($oferta['provincia']);
                                ?>
                            </select>
						</div>
					</div>
					<div class="form-group">
						<label for="localizacion" class="col-sm-2 control-label">Localizacion</label>
						<div class="col-sm-8">
							<input id="localizacion" name="localizacion" class="col-sm-4 form-control" placeholder="Añade aquí la dirección donde se realizará el servicio" value="<?php echo($oferta['localizacion']);?>">
						</div>
					</div>
					<hr>
                    <h4>3. Temas relacionados</h4>
					<div id="etiquetas" class="form-group">
                        <div class="form-inline">
                            <label class="col-sm-2 control-label">
                                Tema
                            </label>
                            <div class="col-lg-10">
                                <input id="tema" type="text" class="form-control" maxlength="45" size="48">
                                <button id=addTopic type="button" class="btn btn-primary" data-toggle="popover" data-content="El tema ya ha sido añadido" onClick="addTema()">Añadir</button>
                                <p class="help-block">Escribe cualquier tema relacionado con tu anuncio. Estos temas se añadiran a tu anuncio como etiquetas que facilitan la búsqueda a tus futuros clientes.</p>
                            </div>
                            <div class="tabla col-lg-4 col-lg-offset-2">
                                &nbsp;
                                <table id="temas" class="table table-striped table-bordered">
                                    <thead>
                                      <tr>
                                          <th>Temas actualmente añadidos</th>
                                      </tr>
                                  </thead>
                                  <tbody id="tags">
									<td id=tag+NUMEROTEMA> 
										<input type="hidden" name="tag+NUMEROTEMA" value="">
										<button type="button" class="deleteTag label label-danger">Eliminar</button> 
									</td>
                                  </tbody>
                              </table>
                            </div>
                        </div>
					</div>
                    <hr>
                    <?php
                        $_SESSION['idOferta']=$oferta['idOferta'];
                        $_SESSION['idOfertante']=$oferta['idOfertante'];
                    ?>
					<button id="create" type="submit" class="btn btn-success">Guardar cambios</button>
                    <button id="back" type="button" class="btn btn-primary" onclick="history.back();">Volver</button>
				</form>
			</section>
		</div>
	</div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
<script src="js/temas.js"></script>
</body>

</html>