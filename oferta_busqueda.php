<?php
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
                                        <img src="/images/clasesBaile.jpg" alt="bootsnipp"
                                             class="img-rounded img-responsive portada" />
                                    </div>
                                    <div class="col-xs-12 col-md-8 section-box">
                                        <h4>
                                           <a href="oferta.php">' . $schl['titulo'] . ' </a>
                                        </h4>
                                        <p>
                                            <small>' . $schl['descripcion'] . '</small>
                                        </p>
                                        <hr/>
                                        <div class="row rating-desc">
                                            <div class="col-lg-12">
                                                <small>
                                                    <label>Valoración</label>
                                                    <span class="glyphicon glyphicon-star"></span>
                                                    <span class="glyphicon glyphicon-star"></span>
                                                    <span class="glyphicon glyphicon-star"></span>
                                                    <span class="glyphicon glyphicon-star"></span>
                                                    (36)
                                                </small>
                                                &nbsp;
                                                <small>
                                                    <label for="">Precio</label>
                                                    <span class="glyphicon glyphicon-euro"></span>
                                                    20&euro;/Hora
                                                </small>
                                                &nbsp;
                                                <small>
                                                    <label for="">Categoría</label>
                                                    ' . $schl['categoria'] . '
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-2 section-box hireButton">
                                        <a href="#" class="btn btn-lg btn-success"><span class="glyphicon glyphicon-hand-right"></span>Contratar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>';