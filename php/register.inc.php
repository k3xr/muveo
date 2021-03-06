<?php
include_once 'db_connect.php';
include_once 'functions.php';

$error_msg = "";

if (isset($_POST['username'], $_POST['nombre'],$_POST['apellidos'], $_POST['p'], $_POST['email'], $_POST['tlf'] )) {

    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $nacionalidad = filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_STRING);
    $apellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $tlf = $_POST['tlf'];

    $tipoUsuario = null;
    if ($_POST['tipo'] == 'Contratante') {
        $tipoUsuario = 0;
    }
    if ($_POST['tipo'] == 'Ofertante') {
        $tipoUsuario = 1;
    }

    if (!filter_var($tlf, FILTER_VALIDATE_INT)) {
        // Not a valid tlf
        $error_msg .= '<p class="error">El teléfono no es válido</p>';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">El E-Mail no es válido</p>';
    }

    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Contraseña no es correcta</p>';
    }

    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.

    // check existing username
    $prep_stmt = "SELECT idUsuario FROM Usuario WHERE nbUsuario = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);

    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            // A user with this username already exists
            $error_msg .= '<p class="error">Este nombre de usuario ya está registrado</p>';
            $stmt->close();
        }
        $stmt->close();
    }
    else {
        $error_msg .= '<p class="error">Error en la base de datos</p>';
        $stmt->close();
    };

    if ($error_msg == "") {

        // Create a random salt
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        // Create salted password
        $password = hash('sha512', $password . $random_salt);

        if ($insert_stmt = $mysqli->prepare("INSERT INTO Usuario (nbUsuario, tipoUsuario, nombre, apellidos, nacionalidad, password, email, telefono, avatarPath, salt) VALUES (?,?,?,?,?,?,?,?,\"/images/avatar.jpg\",?)")) {
            $insert_stmt->bind_param('sssssssss', $username, $tipoUsuario, $nombre, $apellidos, $nacionalidad, $password, $email, $tlf, $random_salt);

            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Registration failure: INSERT');
            }
        }
        header('Location: ./register_success.php');
    }
}