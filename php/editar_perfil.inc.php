<?php
include_once 'db_connect.php';
include_once 'functions.php';
include_once 'class_imgUpldr.php';

sec_session_start();

if(!$_SESSION['user_id']>0) {
    header('Location: ../error.php');
}

$query = 'UPDATE Usuario set ';

if (isset($_POST['nombre'])) {// Nombre
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $query = $query . 'nombre="' . $nombre .'", ';
}

if (isset($_POST['apellidos'])) {// Apellidos
    $apellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING);
    $query = $query . 'apellidos="' . $apellidos .'", ';
}

if (isset($_POST['email'])) {// Email
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $query = $query . 'email="' . $email .'", ';
}

if (isset($_POST['pais'])) {// Nacionalidad
    $nacionalidad = filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_STRING);
    $query = $query . 'nacionalidad="' . $nacionalidad .'", ';
}

if (isset($_POST['tlf'])) {// Telefono
    $tlf = $_POST['tlf'];
    $query = $query . 'telefono="' . $tlf .'", ';
}

if(isset($_FILES['avatar'])) {// Imagen de perfil

    if($_FILES['avatar']['size']>0) {
        $subir = new imgUpldr;
        $subir->_dest = '/var/www/images/perfiles/';
        $subir->_name = basename($_FILES['avatar']['name']);
        $subir->init($_FILES['avatar']);
        $ruta = '/images/perfiles/' . $subir->_name;

        $query = $query . 'avatarPath="' . $ruta . '", ';
    }
}

if (isset($_POST['formacion'])) {// Formacion
    $formacion = $_POST['formacion'];
    $query = $query . 'formacion="' . $formacion.'", ';
}


if(isset($_POST['p'])) {// Password

    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        $error_msg .= '<p class="error">Contraseña no es correcta</p>';
    }

    // Create a random salt
    $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
    // Create salted password
    $password = hash('sha512', $password . $random_salt);

    $query = $query . 'salt="' . $random_salt.'", ';
    $query = $query . 'password="' . $password.'", ';

}

// Ejecuta query
if($query!='UPDATE Usuario set ') {// Si se ha modificado algun campo
    $query = substr($query, 0, -2); // Quita ultima coma y espacio
    $query = $query . ' WHERE idUsuario=' . $_SESSION['user_id'];

    $mysqli->query($query);
    header('Location: ../perfil.php?id=' . $_SESSION['user_id']);
}


