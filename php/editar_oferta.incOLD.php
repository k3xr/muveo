<?php
include_once 'db_connect.php';
include_once 'functions.php';
include_once 'class_imgUpldr.php';

sec_session_start();

if(!$_SESSION['user_id']>0) {
    header('Location: ../error.php');
}

$query = 'UPDATE Usuario set ';

if (isset($_POST['titulo'])) {// Titulo
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
    $query = $query . 'titulo="' . $titulo .'", ';
}

if (isset($_POST['categoria'])) {// Categoria
    $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
    $query = $query . 'categoria="' . $categoria .'", ';
}

if (isset($_POST['descripcion'])) {// Descripcion
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_EMAIL);
    $query = $query . 'descripcion="' . $descripcion .'", ';
}

if(isset($_FILES['portadaPath'])) {// Imagen de portada
    if($_FILES['portadaPath']['size']>0) {
        $subir = new imgUpldr;
        $subir->_dest = '/var/www/images/portadas/';
        $subir->_name = basename($_FILES['portadaPath']['titulo']);
        $subir->init($_FILES['portadaPath']);
        $ruta = '/images/perfiles/' . $subir->_name;

        $query = $query . 'portadaPath="' . $ruta . '", ';
    }
}

if (isset($_POST['precio'])) {// precio
    $precio = $_POST['precio'];
    $query = $query . 'precio="' . $precio.'", ';
}

if (isset($_POST['idioma'])) {// idioma
    $idioma = filter_input(INPUT_POST, 'idioma', FILTER_SANITIZE_STRING);
    $query = $query . 'idioma="' . $idioma .'", ';

    if (isset($_POST['localizacion'])) {// localizacion
        $tlf = $_POST['tlf'];
        $query = $query . 'telefono="' . $tlf .'", ';
    }

// Ejecuta query
    if($query!='UPDATE Oferta set ') {// Si se ha modificado algun campo
        $query = substr($query, 0, -2); // Quita ultima coma y espacio
        $query = $query . ' WHERE idUsuario=' . $_SESSION['user_id'];

        $mysqli->query($query);
        header('Location: ../oferta.php?id=' . $_SESSION['user_id']);
    }
 