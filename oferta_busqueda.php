<?php
include_once 'php/functions.php';
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 17/05/2015
 * Time: 19:00
 */

echo '<li class="list-group-item">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-xs-12 col-lg-2 text-center">
                                        <img src="'.$schl['portadaPath'].'" alt="bootsnipp"
                                             class="img-rounded img-responsive portada" />
                                    </div>
                                    <div class="col-xs-12 col-md-8 section-box">
                                        <h4>
                                           <a href="oferta.php?id='.$schl['idOferta'].'">' . utf8_encode($schl['titulo']) . ' </a>
                                        </h4>
                                        <p>
                                            <small>' . substr(utf8_encode($schl['descripcion']), 0, 70) ."...". '</small>
                                        </p>
                                        <hr/>
                                        <div class="row rating-desc">
                                            <div class="col-lg-12">
                                                <small>
                                                    <label>Valoración</label>
                                                    ';
$v = $schl['valoracion'];
if(!$v>0)$v=0;

for($i=0; $i<5; $i++){
    if($v>$i) echo '<span class="glyphicon glyphicon-star"></span>';
    else echo '<span class="glyphicon glyphicon-star-empty"></span>';
}

echo'
                      ('.$v.')
                      </small>
                      &nbsp;
                      <small>
                          <label for="">Precio</label>
                          <span class="glyphicon glyphicon-euro"></span>
                          <span class="label label-warning">'.$schl['precio'].'&euro; / Hora </span>
                      </small>
                      &nbsp;
                      <small>
                          <label for="">Categoría</label>
                          <span class="label label-info">' . utf8_encode($schl['categoria']) . '</span>
                      </small>
                  </div>
              </div>
          </div>';
            if($_SESSION['user_id']>0) {
                if ($_SESSION['tipo'] == 0) {//Contratante
                    if(!tieneContrato($_SESSION['user_id'],$schl['idOferta'],$mysqli)){
                        echo '<div class="col-xs-12 col-md-2 section-box hireButton">
                    <a href="pasarela.php?id=' . $_SESSION['user_id'] . '&idOferta=' . $schl['idOferta'] . '" class="btn btn-primary"><span class="glyphicon glyphicon-hand-right"></span>Contratar</a>
                </div>';
                    }
                    else{
                        echo '<div class="col-xs-12 col-md-2 section-box hireButton">
                        <button disabled id="btn-contratar" class="btn btn-success">
                        Ya contratada
                    </button>';
                    }

                }
            }
                else{
                  echo '<div class="col-xs-12 col-md-2 section-box hireButton">
                        <button id="btn-contratar" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">
                        <span class="glyphicon glyphicon-hand-right">
                        </span>
                    Contratar
                </button>';
                }
    echo '</div>
        </div>
    </div>
</li>';