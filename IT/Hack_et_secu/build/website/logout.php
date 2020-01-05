<?php

if (isset($_SESSION["team"]) && !empty($_SESSION["team"])) {
    unset($_SESSION["team"]);
    echo "Thanks for logging out";
} else {
    header("Location: index.php");
}

?>