<?php

include_once 'php/nueva_oferta.inc.php';
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
            <form role="form" enctype="multipart/form-data" class="form-horizontal" action="nueva_oferta.php?id=<?php echo $_SESSION['user_id'] ?>" method="post" name="nueva_oferta_form"> <!-- Makes form-groups behave as rows of Bootstrap Grid System -->
                <h4> 1. Información general </h4>
                <!-- Title -->
                <div class="form-group">
                    <label for="titulo" class="col-sm-2 control-label">Titulo*</label>
                    <div class="col-sm-7">
                        <input id="titulo" name='titulo' class="col-sm-4 form-control" placeholder="Titulo del anuncio" required>
                    </div>
                </div>
                <!-- Topic -->
                <div class="form-group">
                    <label for="categoria" class="col-sm-2 control-label">Categoría</label>
                    <div class="col-sm-7">
                        <select id="categoria" name='categoria' class="col-sm-4 form-control">
                            <?php
                            getCategorias('Sin especificar');
                            ?>
                        </select>
                    </div>
                </div>
                <!-- Description -->
                <div class="form-group">
                    <label for="descripcion" class="col-sm-2 control-label">Descripcion</label>
                    <div class="col-sm-8">
                        <textarea id="descripcion" name='descripcion' class="col-sm-6 form-control" rows="8" placeholder="Añade aquí la descripción del anuncio."></textarea>
                    </div>
                </div>
                <!-- Portada -->
                <div class="form-group">
                    <label for="imagenOferta" class="col-sm-2 control-label">Portada</label>
                    <div class="col-sm-8">
                        <input id="imagenOferta" type="file" name="imagenOferta"/>
                        <p class="help-block">Añade una imagen de portada para tu anuncio. Tamaño máximo 720 x 720. Archivos soportados: <strong>.jpg, .jpge, .gif, .png</strong></p>
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
                            <input id="precio" name="precio" type="text" class="form-control">
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
                            <?php
                            getProvincias('Madrid');
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="localizacion" class="col-sm-2 control-label">Localizacion</label>
                    <div class="col-sm-8">
                        <input id="localizacion" name="localizacion" class="col-sm-4 form-control" placeholder="Añade aquí la dirección donde se realizará el servicio">
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