<?php
include_once 'db_connect.php';
include_once 'functions.php';
include_once 'class_imgUpldr.php';

$error_msg = "";

$id = $_GET["id"];

if (isset($_POST['titulo'], $_POST['categoria'], $_POST['descripcion'], $_POST['precio'], $_POST['idioma'], $_POST['provincia'], $_FILES['imagenOferta'])) {

    // Sanitize and validate the data passed in
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
    $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
    $localizacion = filter_input(INPUT_POST, 'localizacion', FILTER_SANITIZE_STRING);
    $provincia = $_POST['provincia'];
    $precio = $_POST['precio'];
    $idioma = $_POST['idioma'];

    $subir= new imgUpldr;
    $subir->_name=basename($_FILES['imagenOferta']['name']);
    $subir->init($_FILES['imagenOferta']);
    $ruta = '/images/ofertas/' . $subir->_name;


    if ($insert_stmt = $mysqli->prepare("INSERT INTO Oferta (idOfertante, titulo, descripcion, categoria, provincia, localizacion, fechaPublicacion, precio, idioma, portadaPath, valoracion) VALUES (?,?,?,?,?,?,?,?,?,?,0)")) {
        $insert_stmt->bind_param('ssssssssss', $id, $titulo, $descripcion, $categoria, $provincia, $localizacion, date("Y-m-d H:i:s"), $precio, $idioma, $ruta);

        // Execute the prepared query.
        if (!$insert_stmt->execute()) {
            header('Location: ../error.php?err=Fallo creando oferta');
        }
    }
    header('Location: ../perfil.php?id=' . $id);

}