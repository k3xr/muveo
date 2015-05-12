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

<div class="container">
    <div class="row row-offcanvas row-offcanvas-left">
        <!-- sidebar -->
        <div class="col-xs-12 col-md-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <ul class="nav" style="background: #ffffff">
                <li>Precio: <br><br><input id="ex2" type="text" class="span2" value="" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[250,450]"/></li>
                <br>
                <li><span id="ex6CurrentSliderValLabel">Comentarios: <span id="ex6SliderVal">3 </span></span><input id="ex7-enabled" type="checkbox"/>
                    <input id="ex6" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-enabled="false" data-slider-value="0"/&t
                </li>
                <br>
                <br>
                <li><a href="#">Everyone</a></li>
                <li><a href="#">Individual</a></li>
                <li><a href="#">Companies</a></li>
            </ul>
        </div>

        <!-- search bar -->
        <div class="col-xs-12 col-md-9">
            <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input type="text" class="form-control input-lg" placeholder="Buscar" />
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <!-- search bar -->

        <!-- main area -->
        <div class="col-xs-12 col-md-9" id="mainPanel">
            <div class="panel panel-info">
                <!-- Default panel contents -->
                <div class="panel-heading">Resultados Búsqueda</div>

                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-2 text-center">
                                        <img src="/images/avatar_test.jpg" alt="bootsnipp"
                                             class="img-rounded img-responsive" />
                                    </div>
                                    <div class="col-xs-12 col-md-8 section-box">
                                        <h3><a href="oferta.php">
                                            Clases particulares desarrollo web </a>
                                        </h3>
                                        <p>
                                            Aprende HTML/CSS/JS en tan solo 6 días!</p>
                                        <hr />
                                        <div class="row rating-desc">
                                            <div class="col-md-12">
                                                <span class="glyphicon glyphicon-stars"></span><span class="glyphicon glyphicon-star">
                                                </span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star">
                                                </span><span class="glyphicon glyphicon-star"></span>(36)<span class="separator">|</span>
                                                <span class="glyphicon glyphicon-comment"></span>(100 Comments)
                                                <span class="glyphicon glyphicon-euro"></span>20/Hora
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-2 section-box hireButton">
                                        <a href="#" class="btn btn-lg btn-primary"><span class="glyphicon glyphicon-hand-right"></span> Hire</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-2 text-center">
                                        <img src="http://rumberanetwork.com/wp-content/uploads/2014/06/cara-delevingne-wallpaper-1848598319.jpg" alt="bootsnipp"
                                             class="img-rounded img-responsive" />
                                    </div>
                                    <div class="col-xs-12 col-md-8 section-box">
                                        <h3><a href="oferta.php">
                                            Clases de Oso Yoga en Fuenlabrada CITY! </a>
                                        </h3>
                                        <p>
                                            Se busca clases de Oso yoga en puntos conflictivos de Madrid!</p>
                                        <hr />
                                        <div class="row rating-desc">
                                            <div class="col-xs-12 col-md-12">
                                                <span class="glyphicon glyphicon-stars"></span><span class="glyphicon glyphicon-star">
                                                </span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star">
                                                </span><span class="glyphicon glyphicon-star"></span>(3)<span class="separator">|</span>
                                                <span class="glyphicon glyphicon-comment"></span>(2 Comments)
                                                <span class="glyphicon glyphicon-euro"></span>200/Hora (Zona conflictiva)
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-2 section-box hireButton">
                                        <a href="#" class="btn btn-lg btn-primary"><span class="glyphicon glyphicon-hand-right"></span> Hire</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-2 text-center">
                                        <img src="/images/clasesProgramacion.jpg" alt="bootsnipp"
                                             class="img-rounded img-responsive" />
                                    </div>
                                    <div class="col-xs-12 col-md-8 section-box">
                                        <h3><a href="oferta.php">
                                            Clases de Programación </a>
                                        </h3>
                                        <p>Java</p>
                                        <hr/>
                                        <div class="row rating-desc">
                                            <div class="col-xs-12 col-md-12">
                                                <span class="glyphicon glyphicon-stars"></span><span class="glyphicon glyphicon-star">
                                                </span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star">
                                                </span><span class="glyphicon glyphicon-star"></span>(45)<span class="separator">|</span>
                                                <span class="glyphicon glyphicon-comment"></span>(50 Comments)
                                                <span class="glyphicon glyphicon-euro"></span>150/Hora
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-2 section-box hireButton">
                                        <a href="#" class="btn btn-lg btn-primary"><span class="glyphicon glyphicon-hand-right"></span> Hire</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-2 text-center">
                                        <img src="/images/clasesBaile.jpg" alt="bootsnipp"
                                             class="img-rounded img-responsive" />
                                    </div>
                                    <div class="col-xs-12 col-md-8 section-box">
                                        <h3><a href="oferta.php">
                                            Clases de Baile </a>
                                        </h3>
                                        <p>Baile de salón</p>
                                        <hr/>
                                        <div class="row rating-desc">
                                            <div class="col-xs-12 col-md-12">
                                                <span class="glyphicon glyphicon-stars"></span><span class="glyphicon glyphicon-star">
                                                </span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star">
                                                </span><span class="glyphicon glyphicon-star"></span>(0)<span class="separator">|</span>
                                                <span class="glyphicon glyphicon-comment"></span>(60000 Comments)
                                                <span class="glyphicon glyphicon-euro"></span>3/Hora
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-2 section-box hireButton">
                                        <a href="#" class="btn btn-lg btn-primary"><span class="glyphicon glyphicon-hand-right"></span> Hire</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-2 text-center">
                                        <img src="/images/clasesCocina.jpg" alt="bootsnipp"
                                             class="img-rounded img-responsive" />
                                    </div>
                                    <div class="col-xs-12 col-md-8 section-box">
                                        <h3><a href="oferta.php">
                                            Clases de Cocina </a>
                                        </h3>
                                        <p>Cocina creativa</p>
                                        <hr/>
                                        <div class="row rating-desc">
                                            <div class="col-xs-12 col-md-12">
                                                <span class="glyphicon glyphicon-stars"></span><span class="glyphicon glyphicon-star">
                                                </span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star">
                                                </span><span class="glyphicon glyphicon-star"></span>(800)<span class="separator">|</span>
                                                <span class="glyphicon glyphicon-comment"></span>(3 Comments)
                                                <span class="glyphicon glyphicon-euro"></span>900000/Hora
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-2 section-box hireButton">
                                        <a href="#" class="btn btn-lg btn-primary"><span class="glyphicon glyphicon-hand-right"></span> Hire</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="panel-footer text-center">
                    <nav>
                        <ul class="pagination ">
                            <li>
                                <a href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li>
                                <a href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div><!-- /.col-xs-12 main -->
    </div><!--/.row-->
</div><!--/.container-->
<!-- Modal para login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myLoginModalLabel" aria-hidden="true">
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
    $("#ex6").on("slide", function(slideEvt) {
        $("#ex6SliderVal").text(slideEvt.value);
    });
    // With JQuery
    $("#ex6").slider();
    $("#ex7-enabled").click(function() {
        if(this.checked) {
            // With JQuery
            $("#ex6").slider("enable");
        }
        else {
            // With JQuery
            $("#ex6").slider("disable");
        }
    });
</script>

</body>
</html>
