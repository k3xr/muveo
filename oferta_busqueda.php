<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 17/05/2015
 * Time: 19:00
 */

echo '<li class="list-group-item">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-xs-12 col-md-2 text-center">
                                        <img src="/images/avatar_test.jpg" alt="bootsnipp"
                                             class="img-rounded img-responsive" />
                                    </div>
                                    <div class="col-xs-12 col-md-8 section-box">
                                        <h3><a href="oferta.php">
                                            ' . $schl['titulo'] . ' </a>
                                        </h3>
                                        <p>
                                            ' . $schl['descripcion'] . '</p>
                                        <hr />
                                        <div class="row rating-desc">
                                            <div class="col-md-12">
                                                <span class="glyphicon glyphicon-stars"></span><span class="glyphicon glyphicon-star">
                                                </span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star">
                                                </span><span class="glyphicon glyphicon-star"></span>(36)<span class="separator">|</span>
                                                <span class="glyphicon glyphicon-euro"></span>' . $schl['categoria'] . '
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-2 section-box hireButton">
                                        <a href="#" class="btn btn-lg btn-primary"><span class="glyphicon glyphicon-hand-right"></span> Hire</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </li>';