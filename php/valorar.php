<?php

include_once 'functions.php';
include_once 'db_connect.php';

sec_session_start();

$idOferta = $_GET["idOferta"];
$idUsuario = $_GET["idUsuario"];
$valoracion = $_GET["valoracion"];

$mysqli->query('Update Contrato set valoracion='.$valoracion.' where idUsuario='.$idUsuario.' and idOferta='.$idOferta);

$total=0;
$count=0;
foreach ($mysqli->query("SELECT * FROM Contrato WHERE idOferta=" . $idOferta) as $contrato){
    $total += $contrato['valoracion'];
    $count++;
}
$total = $total/$count;
$mysqli->query('Update Oferta set valoracion='.$total.' where idOferta='.$idOferta);

$total=0;
$count=0;
foreach ($mysqli->query("SELECT * FROM Oferta WHERE idOfertante=" . $idUsuario) as $oferta){
    $total += $oferta['valoracion'];
    $count++;
}
$total = $total/$count;
$mysqli->query('Update Usuario set valoracion='.$total.' where idUsuario='.$idUsuario);

header('Location: ../oferta.php?id='.$idOferta);



