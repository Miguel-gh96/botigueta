<?php

function debugPHP($array) {
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function redirect($url) {
    die('<script>window.location.href="' . $url . '";</script>');
}

function close_session() {
    $_SESSION = array(); // Destruye todas las variables de la sesión
    session_destroy(); // Destruye la sesión
}

//function to change url to pretty url
function amigable($url, $return = false) {
    $amigableson = URL_AMIGABLES;
    $link = "";
    $i = 0;
    if ($amigableson) {
        $url = explode("&", str_replace("?", "", $url));
        foreach ($url as $key => $value) {
            $aux = explode("=", $value);
            $link .= "/" . $aux[1];
        }
    } else {
        $link = "/index.php" . $url;
    }
    if ($return) {
        return $link;
    }
    echo $link;
}
