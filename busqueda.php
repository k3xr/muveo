<?php
include_once 'php/db_connect.php';
include_once 'php/functions.php';

sec_session_start();

?>
<!DOCTYPE html>
<html>
<head lang="es">

    <?php include 'head.php'; ?>
    <link rel="stylesheet" href="css/bootstrap-slider.css">
    <link rel="stylesheet" href="css/busqueda.css">
    <title>Busca en Muveo</title>
</head>
<body>
<!-- Header -->
<?php include 'header.php'; ?>
<!-- Header End-->

<div class="container main-container">
    <div class="row">
        <!-- sidebar -->
        <aside class="col-xs-12 col-md-3" id="sidebar" role="navigation">
            <h4><strong>Filtros de búsqueda</strong></h4>
            <?php
            //Mantener el estado de los filtros
            //Siempre van a estar todos cuando aplicamos filtros -> comprobamos 1
            if (isset($_POST['precio'])) {
                $precioFiltro = $_POST['precio'];
                $comentariosFiltro = $_POST['comentarios'];
                $categoriaFiltro = $_POST['categoria'];
            } else {//Primer acceso valores por defecto
                $precioFiltro = "5.0,100.0";
                $comentariosFiltro = "1";
                $categoriaFiltro = "";
            }


            echo '<form class="form-horizontal" method="post" action="busqueda.php">
                <div class="form-group">
                    <label for="" class="control-label">Precio</label>
                    <input id="ex2" type="text" class="col-lg-2 span2" value="Precio" data-slider-min="5.0"
                           data-slider-max="100.0" data-slider-step="0.5" data-slider-value="[' . $precioFiltro . ']"
                           name="precio"/>

                </div>
                <div class="form-group">
                    <label for="" class="control-label">Valoración</label>
                    <input id="ex10" type="text" data-slider-max="5.0" data-slider-handle="custom" value=""
                           name="comentarios" data-slider-value="' . $comentariosFiltro . '"/>
                </div>
                <div class="form-group">
                    <label for="categoria" class="control-label">Categoría</label>
                    <select id="categoria" class="col-sm-4 form-control input-sm" name="categoria">
                        <option id="other" value="other">Sin especificar</option>
                        <option id="web_programming" value="web_programming">Programación Web</option>
                        <option id="web_design" value="web_design">Diseño Web</option>
                        <option id="inteligencia_empresarial" value="inteligencia_empresarial">Inteligencia Empresarial</option>
                        <option id="abogacia" value="abogacia">Abogacia</option>
                        <option id="clases" value="clases">Clases particulares</option>
                        <option id="analisis_datos" value="analisis_datos">Análisis de datos</option>
                        <option id="diseno_grafico" value="diseno_grafico">Diseño Gráfico</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="hidden" name="busqueda" value="'.$_POST["busqueda"].'" />
                </div>
                <button type="submit" class="btn btn-primary" value="Login">
                    Aplicar Filtros
                </button>
            </form>';
            ?>
        </aside>
        <!-- search bar -->
        <div class="col-xs-12 col-md-9" id="mainPanel">
            <!-- search bar -->
            <form id="searchForm" class="form-horizontal" method="post" action="busqueda.php">
                <h4><strong>Barra de búsqueda</strong></h4>

                <div class="input-group col-lg-12">
                    <input type="text" name="busqueda" class="col-lg-4 form-control"
                           placeholder="Busca algún tema o actividad que te interese."/>
                   <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit">
                        <i class="glyphicon glyphicon-search"></i>Buscar
                    </button>
                   </span>
                </div>
            </form>
            <!-- search bar -->
            <div class="panel panel-info">
                <!-- Default panel contents -->
                <div class="panel-heading"><strong>Resultados de la búsqueda</strong></div>
                <!-- List group -->
                <ul class="list-group">
                    <?php

                    //INI: Caso de busqueda con searchBar
                    $arrayOfertasAMostrar = null;
                    if (isset($_POST['busqueda']) && $_POST['busqueda'] != "") {
                        $arrayOfertasAMostrar = matching($_POST['busqueda'], $mysqli);
                        $arrayOfertasAMostrar = ' idOferta IN (' .
                            implode(',', array_map('intval', $arrayOfertasAMostrar)) . ')';
                    }

                    /*if (isset($_POST['comentario'])) {
                        $arrayOfertasAMostrar = matching($_POST['busqueda'], $mysqli);
                        $arrayOfertasAMostrar = ' idOferta IN (' .
                            implode(',', array_map('intval', $arrayOfertasAMostrar)) . ')';
                    }*/
                    //FIN: Caso de busqueda

                    //INI: Filtros
                    //Para pruebas
                    //$_POST['precio'] = "10,100";
                   //$_POST['comentarios'] = "0";
                    //$_POST['categoria'] = "other";
                    $rango_precio = explode(",", $_POST['precio']);
                    $_POST['comentarios'] = (is_numeric($_POST['comentarios']) ? (int)$_POST['comentarios'] : 0);
                    if (isset($_POST['precio']) && isset($_POST['comentarios']) && isset($_POST['categoria'])) {
                        if($_POST['categoria'] != "other"){
                            $arrayOfertasAMostrar = $arrayOfertasAMostrar . " precio BETWEEN "
                                . $rango_precio[0] . " AND " . $rango_precio[1] . " AND valoracion >= " .
                                $_POST['comentarios'] . " AND categoria=\"" . $_POST['categoria'] . "\"";
                        }else{
                            $arrayOfertasAMostrar = $arrayOfertasAMostrar . " precio BETWEEN "
                                . $rango_precio[0] . " AND " . $rango_precio[1] . " AND valoracion >= " .
                                $_POST['comentarios'] . "";
                        }
                    }
                    //FIN: Filtros


                    $posts = $db_try->getRowsWithPaging('Oferta',
                        $_GET['_pno'], $_SERVER['PHP_SELF'], $arrayOfertasAMostrar, null, null, null, 5);

                    if (isset($posts) && $posts->isAnyDataAvailable()) {
                        $postsdata = $posts->get();
                        foreach ($postsdata as $schl) {
                            include "oferta_busqueda.php";
                        }
                    }
                    # pagination here
                    echo '<div class="col-md-offset-5">';
                    echo '<p class="text-center">' . $posts . '</p>';
                    echo '</div>';
                    ?>
            </div>
        </div>
        <!-- /.col-xs-12 main -->
    </div>
    <!--/.row-->
</div>
<!--/.container-->
<!-- Modal para login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myLoginModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3>Inicia sesión para continuar</h3>
                <h5>¿No tienes cuenta? ¡Registrate <a href="register.php"> aquí</a> en menos de un minuto!</h5>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="inputUsername" class="col-xs-4 control-label"> Nombre de usuario </label>

                        <div class="col-xs-6">
                            <input type="text" class="form-control" id="inputUsername" placeholder="Usuario">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="col-xs-4 control-label"> Contraseña </label>

                        <div class="col-xs-6">
                            <input type="password" class="form-control" id="inputPassword" placeholder="Contraseña">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">
                    Iniciar sesión
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal para login -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-slider.js"></script>
<script>
    $("#ex2").slider({});
    $("#ex6").slider();
    $("#ex6").on("slide", function (slideEvt) {
        $("#ex6SliderVal").text(slideEvt.value);
    });
    // With JQuery
    $("#ex10").slider({});

    $('#<?=$_POST['categoria']?>').prop('selected', true);

</script>

</body>
</html>
