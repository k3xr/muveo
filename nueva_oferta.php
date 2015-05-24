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
<div class="container main-container">
    <div class="row">
        <section>
            <h2 id="title">Creación de nuevo anuncio</h2>
            <hr>
            <form role="form" class="form-horizontal"> <!-- Makes form-groups behave as rows of Bootstrap Grid System -->
                <h4> 1. Información general </h4>
                <!-- Title -->
                <div class="form-group">
                    <label for="titulo" class="col-sm-2 control-label">Titulo*</label>
                    <div class="col-sm-7">
                        <input id="titulo" class="col-sm-4 form-control" placeholder="Titulo del anuncio" required>
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
                    <div class="col-sm-8">
                        <textarea id="descripcion" class="col-sm-6 form-control" rows="8" placeholder="Añade aquí la descripción del anuncio."></textarea>
                    </div>
                </div>
                <!-- Portada -->
                <div class="form-group">
                    <label for="imagenOferta" class="col-sm-2 control-label">Portada</label>
                    <div class="col-sm-8">
                        <input id="imagenOferta" type="file" name="imagenOferta"/>
                        <p class="help-block">Añade una imagen de portada para tu anuncio. Archivos soportados: <strong>.jpg, .jpge, .gif, .png</strong></p>
                    </div>
                </div>
                <hr>
                <h4> 2. Datos relevantes </h4>
                <!-- Price -->
                <div class="form-group">
                    <div class="form-inline">
                        <label for="precio" class="col-sm-2 control-label" required>
                            Precio*
                        </label>
                        <div class="col-sm-4">
                            <input id="precio" type="text" class="form-control">
                            &nbsp;€/hora
                            <!-- Tasa -->
                            <!--<select id="precio_tiempo" class="form-control">
                                    <option>Por hora</option>
                                    <option>Por semana</option>
                                    <option>Por mes</option>
                                    <option>Total</option>
                            </select>-->
                        </div>
                    </div>
                </div>
                <!-- Languages -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Idioma</label>
                    <div class="col-sm-2">
                        <input type="radio" name="idioma" value="es" checked> Español
                        <br>
                        <input type="radio" name="idioma" value="en"> Inglés
                        <br>
                        <input type="radio" name="idioma" value="ch"> Chino
                        <br>
                        <input type="radio" name="idioma" value="de"> Alemán
                        <br>
                        <input type="radio" name="idioma" value="fr"> Francés
                    </div>
                </div>
                <!-- Location -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Provincia*</label>
                    <div class="col-sm-3">
                        <select name="provincia" class="form-control" required>
                            <option value='1'>Seleccionar</option>
                            <option value='2'>Álava</option>
                            <option value='3'>Albacete</option>
                            <option value='4'>Alicante/Alacant</option>
                            <option value='5'>Almería</option>
                            <option value='6'>Asturias</option>
                            <option value='7'>Ávila</option>
                            <option value='8'>Badajoz</option>
                            <option value='9'>Barcelona</option>
                            <option value='10'>Burgos</option>
                            <option value='11'>Cáceres</option>
                            <option value='12'>Cádiz</option>
                            <option value='13'>Cantabria</option>
                            <option value='14'>Castellón/Castelló</option>
                            <option value='15'>Ceuta</option>
                            <option value='16'>Ciudad Real</option>
                            <option value='17'>Córdoba</option>
                            <option value='18'>Cuenca</option>
                            <option value='19'>Girona</option>
                            <option value='20'>Las Palmas</option>
                            <option value='21'>Granada</option>
                            <option value='22'>Guadalajara</option>
                            <option value='23'>Guipúzcoa</option>
                            <option value='24'>Huelva</option>
                            <option value='25'>Huesca</option>
                            <option value='26'>Illes Balears</option>
                            <option value='27'>Jaén</option>
                            <option value='28'>A Coruña</option>
                            <option value='29'>La Rioja</option>
                            <option value='30'>León</option>
                            <option value='31'>Lleida</option>
                            <option value='32'>Lugo</option>
                            <option value='33'>Madrid</option>
                            <option value='34'>Málaga</option>
                            <option value='35'>Melilla</option>
                            <option value='36'>Murcia</option>
                            <option value='37'>Navarra</option>
                            <option value='38'>Ourense</option>
                            <option value='39'>Palencia</option>
                            <option value='40'>Pontevedra</option>
                            <option value='41'>Salamanca</option>
                            <option value='42'>Segovia</option>
                            <option value='43'>Sevilla</option>
                            <option value='44'>Soria</option>
                            <option value='45'>Tarragona</option>
                            <option value='46'>Santa Cruz de Tenerife</option>
                            <option value='47'>Teruel</option>
                            <option value='48'>Toledo</option>
                            <option value='49'>Valencia/Valéncia</option>
                            <option value='50'>Valladolid</option>
                            <option value='51'>Vizcaya</option>
                            <option value='52'>Zamora</option>
                            <option value='53'>Zaragoza</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="localizacion" class="col-sm-2 control-label">Localizacion</label>
                    <div class="col-sm-8">
                        <input id="localizacion" class="col-sm-4 form-control" placeholder="Añade aquí la dirección donde se realizará el servicio">
                    </div>
                </div>
                <hr>
                <h4>3. Temas relacionados</h4>
                <div id="etiquetas" class="form-group">
                    <div class="form-inline">
                        <label class="col-sm-2 control-label">
                            Tema
                        </label>
                        <div class="col-lg-7">
                            <input id="tema" type="text" class="form-control" maxlength="45" size="48">
                            <button id=addTopic type="button" class="btn btn-primary" data-toggle="popover" data-content="El tema ya ha sido añadido" onClick="addTema()">Añadir</button>
                            <p class="help-block">Escribe cualquier tema relacionado con tu anuncio. Estos temas se añadiran a tu anuncio como etiquetas que facilitan la búsqueda a tus futuros clientes.</p>
                        </div>
                        <div class="tabla col-lg-4 col-lg-offset-2">
                            &nbsp;
                            <table id="temas" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Temas añadidos</th>
                                </tr>
                                </thead>
                                <tbody id="tags">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Submit -->
                <!-- <div class="col-sm-offset-6 col-sm-2"> -->
                <hr>
                <button id="create" type="submit" class="btn btn-success">Crear oferta</button>
                <button id="back" class="btn btn-primary" onclick="history.back()">Volver</button>
                <!-- </div> -->
            </form>
        </section>
    </div>
</div>
<!-- Footer -->
<footer id="lema" class="">
    © muveo.sytes.net 2015
</footer>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="js/bootstrap.min.js"></script>
<script>
    function addTema(){
        var tag = document.getElementById("tema").value;
        tag = $.trim(tag);
        if(tag===""){
            return;
        }
//           var options = {delay: {"show": 100, "hide":1100}, trigger: "click"}
//           $("#addTopic").popover(options);
        var arrayTemas = [];
        $( "td > input" ).each( function() {
            arrayTemas.push( $( this ).val() );
        });
        var added = $.inArray(tag.toLowerCase(),arrayTemas);
        if( added < 0 ){
            arrayTemas.push(tag);
            var input = document.createElement('tr');
            input.innerHTML = "<td id=tag"+arrayTemas.length+
            "><input type=\"hidden\" name=\"tag"+arrayTemas.length+"\" value=\""+tag.toLowerCase()+"\">"+tag+
            "<button type=\"button\" class=\"btn deleteTag label label-danger\">Eliminar</button></td>"
            $("#tags").append(input);
            $("button.deleteTag").bind("click",function(){
                $(this).closest("td").remove();
            });
        }
        else{
//               $("#addTopic").popover("show");
//               onClick=\"delTema()\"
        }
    }
</script>
</body>
</html>