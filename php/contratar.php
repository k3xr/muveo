<?php
include_once 'db_connect.php';
include_once 'functions.php';

$error_msg = "";

$id = $_GET["id"];
$idOferta = $_GET["idOferta"];

if ($insert_stmt = $mysqli->prepare("INSERT INTO Contrato (idUsuario, idOferta, fechaContratacion, valoracion) VALUES (?,?,?,0)")) {
    $insert_stmt->bind_param('sss', $id, $idOferta, date("Y-m-d H:i:s"));

    // Execute the prepared query.
    if (!$insert_stmt->execute()) {
        header('Location: ../error.php?err=Fallo creando contrato');
    }
}
header('Location: ../perfil.php?id=' . $id);