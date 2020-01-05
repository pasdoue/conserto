<?php

$cookie_name = "admin";
$cookie_value = "false";

if(!isset($_COOKIE[$cookie_name])) {
    setcookie($cookie_name, base64_encode(strval($cookie_value)), 0);
} else {
    $cookie_decrypt = base64_decode($_COOKIE[$cookie_name]);
    if ( strcmp( strtolower($cookie_decrypt), "true") == 0) {
        echo "Votre grand mère est fière de vous! Vous venez tout juste de devenir le roi du dessert! <br>";
        echo "Voici le mot de passe : {C00ki3s_4re_g00d}";
    } else {
        echo "Erf, vous n'etes pas le maître des cookies...";
    }
}


?>
