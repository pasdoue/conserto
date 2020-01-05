<?php

session_start();
require_once('class/secu_domains.php');

$chall_name = $_POST["chall_name"];
$chall_cat = $_POST["chall_cat"];
$chall_solution = $_POST["resp"];

$secu_domains = new Secu_domains;
$team = unserialize($_SESSION["team"]);

$chall_solved = $secu_domains->is_chall_solved($chall_name, $chall_cat, $chall_solution);

if ($chall_solved==0) {
    $secu_domains->update_chall_solved_bdd($chall_name, $chall_cat, $team->get_id(), $team->get_score());
    //$_SESSION update for score is done inside the index
}

echo $chall_solved;

?>
