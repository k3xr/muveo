<!DOCTYPE html>
<head>
	<title> Muveo - Nueva Oferta </title>
    <?php include 'head.php'; ?>
    <link rel="stylesheet" type="text/css" href="css/nueva_oferta.css">
</head>
<body>
<!-- Header -->
<?php include 'header.php'; ?>
<!-- Header End-->

	<!-- Main container -->
	<div id="main-container" class="container">
		<div class="row">
			<section class="col-lg-offset-1 col-lg-11">
				<form role="form" class="form-horizontal"> <!-- Makes form-groups behave as rows of Bootstrap Grid System -->
					<h4> Información general </h4>
					<!-- Title -->
					<div class="form-group">
						<label for="titulo" class="col-sm-2 control-label">Titulo</label>
						<div class="col-sm-7">
							<input id="titulo" class="col-sm-4 form-control" placeholder="Titulo del anuncio">
						</div> 
					</div>
					<!-- Topic -->
					<div class="form-group">
						<label for="categoria" class="col-sm-2 control-label">Categoría</label>
						<div class="col-sm-7">
							<select id="categoria" class="col-sm-4 form-control">
								<option value="other">Sin especificar</option>
								<option value="web_programming">Programación Web</option>
								<option value="web_design">Diseño Web</option>
								<option value="inteligencia_empresarial">Inteligencia Empresarial</option>
								<option value="abogacia">Abogacia</option>
								<option value="clases">Clases particulares</option>
								<option value="analisis_datos">Análisis de datos</option>
                                <option value="diseno_grafico">Diseño Gráfico</option>
							</select>
						</div>
					</div>
					<!-- Description -->
					<div class="form-group">
						<label for="descripcion" class="col-sm-2 control-label">Descripcion</label>
						<div class="col-sm-7">
							<textarea id="descripcion" class="col-sm-6 form-control" rows="5" placeholder="Añade aquí la descripción del anuncio."></textarea>
						</div>
					</div>
					<hr>
					<h4> Datos relevantes </h4>
					<!-- Price -->
					<div class="form-group">
						<div class="form-inline">
							<label for="precio" class="col-sm-2 control-label">
								Precio
							</label>
							<div class="col-sm-2">
								<input id="precio" type="text" class="form-control" style="width: 65px; text-align: right">
								&nbsp;€/hora
							</div>
<!--                            <div class="col-offset-sm-2 col-sm-3">
                                <select id="precio_tiempo" class="form-control">
                                    <option>Por hora</option>
                                    <option>Por semana</option>
                                    <option>Por mes</option>
                                    <option>Total</option>
                                </select>
                            </div>-->
						</div>
					</div>
					<!-- Languages -->
					<div class="form-group">
						<label class="col-sm-2 control-label">Idioma</label>
                            <div class="col-sm-2">
                                <input type="radio" name="idioma" value="Espanol" checked> Español
                                <br>
                                <input type="radio" name="idioma" value="Ingles"> Inglés
                                <br>
                                <input type="radio" name="idioma" value="Frances"> Francés
                                <br>
                                <input type="radio" name="idioma" value="Aleman"> Alemán
                                <br>
                                <input type="radio" name="idioma" value="Italiano"> Italiano
                                <br>
                                <input type="radio" name="idioma" value="Chino"> Chino
                            </div>
					</div>
					<!-- Location -->
					<div class="form-group">
						<label class="col-sm-2 control-label">País</label>
						<div class="col-sm-3">
							<select class="form-control">
							    <option value="Alemania" title="Alemania">Alemania</option>
								<option value="España" title="España" selected>España</option>
								<option value="Estados Unidos" title="United States">Estados Unidos</option>
							    <option value="Francia" title="Francia">Francia</option>
								<option value="Holanda" title="Holanda">Holanda</option>
							    <option value="Italia" title="Italy">Italia</option>
								<option value="Portugal" title="Portugal">Portugal</option>
								<option value="Reino Unido" title="Reino Unido">Reino Unido</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="localizacion" class="col-sm-2 control-label">Localizacion</label>
						<div class="col-sm-7">
							<input id="localizacion" class="col-sm-4 form-control" placeholder="Añade aquí la dirección donde se realizará el servicio">
						</div>
					</div>
					<hr>
					<h4>Temas relacionados</h4>
					<div id="etiquetas" class="form-group">
                        <div class="form-inline">
                            <label class="col-sm-2 control-label">
                                Tema
                            </label>
                            <div class="col-sm-6">
                                <input id="tema" type="text" class="form-control">
                                <button type="button" class="btn btn-primary" onClick="addTema()">Añadir</button>
                                <div class="temas">
                                  &nbsp;
                                   <table id="temas" class="table table-striped table-bordered">
                                      <thead>
                                          <tr>
                                              <th>Temas</th>
                                          </tr>
                                      </thead>
                                      <tbody id="tags">
                                      </tbody>
                                   </table>
                                </div>
                            </div>
                        </div>
					</div>
					<!-- Submit -->
					<!-- <div class="col-sm-offset-6 col-sm-2"> -->
					<hr>
					<button id="create" type="submit" class="btn btn-primary">Crear oferta</button>
					<!-- </div> -->
				</form>
			</section>
		</div>
	</div>
	<!-- Footer -->
	<footer id="lema" class="">
		© muveo.sytes.net 2015
	</footer>
	 <script>
       function addTema(){
           var tag = document.getElementById("tema").value;
           var arrayTemas = new Array();
           arrayTemas.push(tag);
           var input = document.createElement('tr');
           input.innerHTML = "<td><input type=\"hidden\" name=\"tag"+arrayTemas.length+"\" value=\""+tag+"\">"+tag+"</td>"
           document.getElementById("tags").appendChild(input); // put it into the DOM
       }
        function delTema(){
            
        }
    </script>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Bootstrap Form Helpers -->
	<script src="js/bootstrap-formhelpers.js"></script>
</body>