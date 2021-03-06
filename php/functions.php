<?php
include_once 'configuration.php';
include_once 'db_connect.php';

function sec_session_start() {
//    $session_name = 'muveoSession';   // Set a custom session name
//    $secure = SECURE;
//    // This stops JavaScript being able to access the session id.
//    $httponly = true;
//     Forces sessions to only use cookies.
//    if (ini_set('session.use_only_cookies', 1) === FALSE) {
//        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
//        exit();
//    }
//    // Gets current cookies params.
//    $cookieParams = session_get_cookie_params();
//    session_set_cookie_params($cookieParams["lifetime"],
//        $cookieParams["path"],
//        $cookieParams["domain"],
//        $secure,
//        $httponly);
    // Sets the session name to the one set above.
//    session_name($session_name);
    session_start();            // Start the PHP session
    session_regenerate_id(true);    // regenerated the session, delete the old one.
}

function login($username, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible.
    if ($stmt = $mysqli->prepare("SELECT idUsuario, nbUsuario, password, salt, avatarPath, tipoUsuario
                FROM Usuario WHERE nbUsuario = ? LIMIT 1")) {
        $stmt->bind_param('s', $username);  // Bind "$username" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id, $username, $db_password, $salt, $avatar, $tipo);
        $stmt->fetch();

        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts

            if (checkbrute($user_id, $mysqli) == true) {
                // Account is locked
                // TODO: Send an email to user saying their account is locked
                return false;
            } else {
                // Check if the password in the database matches the password the user submitted.
                if ($db_password == $password) {

                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/",
                        "",
                        $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                    $_SESSION['avatar'] = $avatar;
                    $_SESSION['tipo'] = $tipo;
                    // Login successful..

                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $mysqli->query("INSERT INTO LoginAttempts(idUsuario, time)
                                    VALUES ('$user_id', '$now')");
                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    }
}

function checkbrute($user_id, $mysqli) {
    // Get timestamp of current time
    $now = time();

    // All login attempts are counted from the past hour.
    $valid_attempts = $now - (60 * 60);

    if ($stmt = $mysqli->prepare("SELECT time
                             FROM LoginAttempts
                             WHERE idUsuario = ?
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);

        // Execute the prepared query.
        $stmt->execute();
        $stmt->store_result();

        // If there have been more than 5 failed logins
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}

function login_check($mysqli) {
    // Check if all session variables are set

    if (isset($_SESSION['user_id'],
        $_SESSION['username'],
        $_SESSION['login_string'])) {

        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT password
                                      FROM Usuario
                                      WHERE idUsuario = ? LIMIT 1")) {

            // Bind "$user_id" to parameter.
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {

                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if ($login_check == $login_string) {
                    // Logged In!!!!
                    return true;
                } else {
                    // Not logged in
                    return false;
                }
            } else {
                // Not logged in
                return false;
            }
        } else {
            // Not logged in
            return false;
        }
    } else {
        // Not logged in
        return false;
    }
}

function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

function matching($word, $mysqli){

    $resultArray = array();
    $toSearch = "%".$word."%";

    if ($stmt = $mysqli->prepare("SELECT distinct Oferta.idOferta FROM Oferta, EtiquetasOferta, Etiqueta WHERE
                                        Oferta.titulo LIKE ? OR (Oferta.idOferta = EtiquetasOferta.idOferta
                                        AND EtiquetasOferta.idEtiqueta = Etiqueta.idEtiqueta AND Etiqueta.nombre LIKE ?)")) {

//    if ($stmt = $mysqli->prepare("SELECT idOferta FROM Oferta WHERE titulo like ?")) {
        $stmt->bind_param('ss', $toSearch, $toSearch);
        $stmt->execute();
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($idOferta);

        if ($stmt->num_rows < 1) {
            return 'na';
            return false;
        }
        else{
            $iter = 0;
            while($stmt->fetch()){
                $resultArray[$iter] = $idOferta;
                $iter++;
            }
            $stmt->free_result();
            $stmt->close();
            return $resultArray;
        }
    }
    return false;
}

function getPaises($paischecked){
    $array = explode("\n", file_get_contents('paises.txt'));
    foreach($array as $pais){
        $pais = substr($pais, 0, -1);
        if(strcmp ($pais , $paischecked ) == 0){
            printf("<option selected=\"selected\" value=\"%s\" title=\"%s\"> %s </option>",$pais,$pais,$pais);
        }
        else{
            printf("<option value=\"%s\" title=\"%s\"> %s </option>",$pais,$pais,$pais);
        }
    }
}

function getProvincias($provincia){
    $array = explode("\n", file_get_contents('provincias.txt'));
    foreach($array as $prov){
        $prov = substr($prov, 0, -1);
        if(strcmp ($prov , $provincia ) == 0){
            printf("<option selected=\"selected\" value=\"%s\" title=\"%s\"> %s </option>",$prov,$prov,$prov);
        }
        else{
            printf("<option value=\"%s\" title=\"%s\"> %s </option>",$prov,$prov,$prov);
        }
    }
}

function getCategorias($default){
    $array = explode("\n", file_get_contents('categorias.txt'));
    foreach($array as $categoria){
        $categoria = substr($categoria, 0, -1);
        if(strcmp ($categoria , $default ) == 0){
            printf("<option id=\"%s\" selected=\"selected\" value=\"%s\" title=\"%s\"> %s </option>",$categoria,$categoria,$categoria,$categoria);
        }
        else{
            printf("<option id=\"%s\" value=\"%s\" title=\"%s\"> %s </option>",$categoria,$categoria,$categoria,$categoria);
        }
    }
}

function getUser($id, $mysqli){
    foreach ($mysqli->query('SELECT * FROM Usuario WHERE idUsuario=' . $id) as $user) ;
    return $user;
}

function getOferta($id, $mysqli){
    foreach($mysqli->query('SELECT * FROM Oferta WHERE idOferta=' . $id) as $oferta);
    return $oferta;
}

function getOfertadas($id, $mysqli){
    $array = array();
    foreach ($mysqli->query("SELECT * FROM Oferta WHERE idOfertante=" . $id) as $oferta){
        array_push($array, $oferta);
    }
    return $array;
}

function getContratadas($id, $mysqli){
    $array = array();
    foreach ($mysqli->query("SELECT * FROM Oferta, Contrato WHERE Oferta.idOferta=Contrato.idOferta and Contrato.idUsuario=" . $id) as $oferta){
        array_push($array, $oferta);
    }
    return $array;
}

function getAnunciante($idOferta, $mysqli){
  $array = array();
  foreach ($mysqli->query("SELECT * FROM Usuario, Oferta WHERE Usuario.idUsuario=Oferta.idOfertante and Oferta.idOferta=" . $idOferta) as $anunciante){
    array_push($array, $anunciante);
  }
  return $array;
}

function tieneContrato($user, $oferta, $mysqli){
    $count=0;
    foreach ($mysqli->query('SELECT * FROM Contrato WHERE idUsuario=' . $user . ' and idOferta='.$oferta) as $contrato){
        $count++;
    }
    if($count>0)return true;
    else return false;
}

?>