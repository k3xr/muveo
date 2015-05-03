<?php
include_once 'db_connect.php';
include_once 'functions.php';

$error_msg = "";

if (isset($_POST['username'], $_POST['email'], $_POST['p'], $_POST['apellidos'], $_POST['tlf'] )) {

    var_dump($_POST['pais']);
    var_dump('asd');
    die();


    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $apellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $tlf = $_POST['tlf'];

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
    $prep_stmt = "SELECT idUsuario FROM Usuario WHERE idUsuario = ? LIMIT 1";
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

        if ($insert_stmt = $mysqli->prepare("INSERT INTO Usuario (nb_usuario, tipo_usuario) VALUES (?,1)")) {
            $insert_stmt->bind_param('s', $username);

            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Registration failure: INSERT');
            }
        }

        $idUsuario = null;
        if ($result = $mysqli->query("SELECT idUsuario FROM Usuario WHERE nb_usuario='$username'")) {
            $row = mysqli_fetch_assoc($result);
            $idUsuario =$row['idUsuario'];
            $result->close();
        }

        if ($insert_stmt = $mysqli->prepare("INSERT INTO Contratante (idUsuario, nombre, apellidos, password, email, telefono, salt)
                                            VALUES ($idUsuario, ?, ?, ?, ?, ?, ?)")) {
            $insert_stmt->bind_param('ssssss', $username, $apellidos, $password, $email, $tlf, $random_salt);

            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Registration failure: INSERT');
            }
        }
        header('Location: ./register_success.php');
    }
}