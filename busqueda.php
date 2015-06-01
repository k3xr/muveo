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

<div class="container main-container well">
    <div class="row">
        <!-- sidebar -->
        <aside class="col-xs-12 col-md-3" id="sidebar" role="navigation">
            <h4><strong>Filtros de búsqueda</strong></h4>
            <hr>
            <?php
            //Mantener el estado de los filtros
            //Siempre van a estar todos cuando aplicamos filtros -> comprobamos 1
            if (isset($_POST['precio'])) {
                $precioFiltro = $_POST['precio'];
                $comentariosFiltro = $_POST['comentarios'];
                $categoriaFiltro = $_POST['categoria'];
            } else {//Primer acceso valores por defecto
                $precioFiltro = "5.0,100.0";
                $comentariosFiltro = "0";
                $categoriaFiltro = "";
            }


            echo '<form class="form-horizontal" method="post" action="busqueda.php">
                <div class="form-group">
                    <label for="" class="control-label">Precio</label>
                    &nbsp;
                    <input id="ex2" type="text" class="col-lg-2 span2" value="Precio" data-slider-min="5.0"
                           data-slider-max="100.0" data-slider-step="0.5" data-slider-value="[' . $precioFiltro . ']"
                           name="precio"/>

                </div>
                <div class="form-group">
                    <label for="" class="control-label">Valoración</label>
                    &nbsp;
                    <input id="ex10" type="text" data-slider-max="5.0" data-slider-handle="custom" value=""
                           name="comentarios" data-slider-value="' . $comentariosFiltro . '"/>
                </div>
                <div class="form-group">
                    <label for="categoria" class="control-label">Categoría</label>
                    <br>
                    <select id="categoria" class="col-sm-4 form-control input-sm" name="categoria">';

            $oferta['categoria'] = $_POST['categoria'];
            getCategorias($oferta['categoria']);

            echo '

                    </select>
                </div>
                <div class="form-group">
                    <input type="hidden" name="busqueda" value="' . $_POST["busqueda"] . '" />
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
                    <input type="text" name="busqueda" class="col-lg-4 form-control input-sm"
                           placeholder="Busca algún tema o actividad que te interese."/>
                   <span class="input-group-btn">
                    <button id="buscarbtn" class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-search"></i>Buscar
                    </button>
                   </span>
                </div>
            </form>
            <!-- search bar -->
            <!-- Filter By -->
            <form id="filterBy" class="form-horizontal" method="post" action="busqueda.php">
                    <label class="filter-col" for="pref-orderby">Ordernar por:</label>
                    <input name="pref-orderby" type="submit" class="btn btn-default" value="Precio descendente">
                    </input>
            </form>
            <!-- form group [order by] -->
            <!-- Filter By -->
            <!-- Results -->
            <div class="panel panel-info">
                <!-- Default panel contents -->
                <div class="panel-heading"><strong>Resultados de la búsqueda</strong></div>
                <!-- List group -->
                <ul class="list-group">
                    <?php

                    //Arreglando paginacion con filtros
                    if (isset($_POST['busqueda'])) {
                        $_SESSION["busqueda"] = $_POST['busqueda'];

                    } else if (isset($_SESSION["busqueda"])) {
                        $_POST['busqueda'] = $_SESSION["busqueda"];
                    }
                    //INI: Caso de busqueda con searchBar
                    $arrayOfertasAMostrar = null;
                    if (isset($_POST['busqueda']) && isset($_POST['precio'])) {
                        $arrayOfertasAMostrar = matching($_POST['busqueda'], $mysqli);
                        $arrayOfertasAMostrar = ' idOferta IN (' .
                            implode(',', array_map('intval', $arrayOfertasAMostrar)) . ') AND';
                    } else if (isset($_POST['busqueda'])) {
                        $arrayOfertasAMostrar = matching($_POST['busqueda'], $mysqli);
                        $arrayOfertasAMostrar = ' idOferta IN (' .
                            implode(',', array_map('intval', $arrayOfertasAMostrar)) . ')';
                    }
                    //FIN: Caso de busqueda
                    //INI: Filtros
                    $rango_precio = explode(",", $_POST['precio']);
                    $_POST['comentarios'] = (is_numeric($_POST['comentarios']) ? (int)$_POST['comentarios'] : 0);
                    if (isset($_POST['precio']) && isset($_POST['comentarios']) && isset($_POST['categoria'])) {
                        if ($_POST['categoria'] != "Sin especificar") {
                            $arrayOfertasAMostrar = $arrayOfertasAMostrar . " precio BETWEEN "
                                . $rango_precio[0] . " AND " . $rango_precio[1] . " AND valoracion >= " .
                                $_POST['comentarios'] . " AND categoria=\"" . $_POST['categoria'] . "\"";
                        } else {
                            $arrayOfertasAMostrar = $arrayOfertasAMostrar . " precio BETWEEN "
                                . $rango_precio[0] . " AND " . $rango_precio[1] . " AND valoracion >= " .
                                $_POST['comentarios'] . "";
                        }
                        //FIN: Filtros
                    }

                    //En caso de que estemos usando la paginacion el metodo nos obliga a usar la misma query
                    if(isset($_GET['_pno'])){
                        $arrayOfertasAMostrar = $_SESSION['queryCompleta'];
                        if(isset($_POST['pref-orderby'])){
                            $arrayOfertasAMostrar = $arrayOfertasAMostrar." ORDER BY precio DESC";
                        }
                    }

                    //Tenemos en cuenta si se desea ordenar los resultados
                    if(isset($_POST['pref-orderby'])){
                        $arrayOfertasAMostrar = $arrayOfertasAMostrar." ORDER BY precio DESC";
                    }

                    $posts = $db_try->getRowsWithPaging('Oferta',
                        $_GET['_pno'], $_SERVER['PHP_SELF'], $arrayOfertasAMostrar, null, null, null, 5);

                    //Guardamos la query para poder reutilizarla en caso de usar paginacion
                    if(!isset($_GET['_pno'])){
                        $_SESSION['queryCompleta'] = $arrayOfertasAMostrar;
                    }

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
<?php include 'modal.php'?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-slider.js"></script>
<script>
    $("#ex2").slider({});

    // With JQuery
    $("#ex10").slider({});
    $('#<?=$_POST['categoria']?>').prop('selected', true);
</script>

</body>
</html>
