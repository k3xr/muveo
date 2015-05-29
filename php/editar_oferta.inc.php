<?php
include_once 'db_connect.php';
include_once 'functions.php';
include_once 'class_imgUpldr.php';

sec_session_start();

/*
if (!($_SESSION['idOferta']>0 &&
        $_SESSION['idOfertante']>0 &&
        $_SESSION['user_id']>0 &&
    (int)$_SESSION['user_id']==(int)$_SESSION['idOfertante'])){
        header('Location: ../error.php');
}
*/


$query = 'UPDATE Oferta set ';

if (isset($_POST['titulo'])) {// Titulo
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
    $query = $query . 'titulo="' . $titulo .'", ';
}

if (isset($_POST['categoria'])) {// Categoria
    $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
    $query = $query . 'categoria="' . $categoria .'", ';
}

if (isset($_POST['descripcion'])) {// Descripcion
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
    $query = $query . 'descripcion="' . $descripcion .'", ';
}

if(isset($_FILES['imagenOferta'])) {// Imagen de portada
    if($_FILES['imagenOferta']['size']>0) {
        $subir = new imgUpldr;
        $subir->_dest = '/var/www/images/ofertas/';
        $subir->_name = basename($_FILES['imagenOferta']['name']);
        $subir->init($_FILES['imagenOferta']);
        $ruta = '/images/ofertas/' . $subir->_name;

        $query = $query . 'portadaPath="' . $ruta . '", ';
    }
}

if (isset($_POST['precio'])) {// precio
    $precio = $_POST['precio'];
    $query = $query . 'precio=' . $precio.', ';
}

if (isset($_POST['idioma'])) {// idioma
    $idioma = $_POST['idioma'];
    $query = $query . 'idioma="' . $idioma . '", ';
}

if (isset($_POST['provincia'])) {// localizacion
    $provincia = $_POST['provincia'];
    $query = $query . 'provincia="' . $provincia .'", ';
}

if (isset($_POST['localizacion'])) {// localizacion
    $localizacion = filter_input(INPUT_POST, 'localizacion', FILTER_SANITIZE_STRING);
    $query = $query . 'localizacion="' . $localizacion .'", ';
}
 
// Ejecuta query
if($query!='UPDATE Oferta set ') {// Si se ha modificado algun campo
    $query = substr($query, 0, -2); // Quita ultima coma y espacio
    $query = $query . ' WHERE idOferta=' . $_SESSION['idOferta'];

    $mysqli->query($query);
    header('Location: ../oferta.php?id=' . $_SESSION['idOferta']);
}
 