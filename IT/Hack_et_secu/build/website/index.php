<?php
  session_start();

  //make sure team is already logged in before printing challenges
  //code is here to prevent header already sent error
  if ( !isset($_SESSION["team"]) || empty($_SESSION["team"]) ) {
    if ( !(isset($_GET["page"]) && ($_GET["page"]=="register.php" || $_GET["page"]=="login.php") )) {
      header("Location: index.php?page=login.php");
      exit();
    }
  } else {
    require_once('class/secu_domains.php');
    //as the score is updated every time user send his correct answer we need to update the $_SESSION infos with the last data inserted inside BDD
    $team = unserialize($_SESSION["team"]);
    $team_update = new Team($team->get_id());
    $_SESSION["team"] = serialize($team_update);
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Conserto challenges</title>

    <!-- <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/album/"> -->

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Bootstrap core JS -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <!-- <link href="album.css" rel="stylesheet"> -->
  </head>
  <body>
    <header>
      <div class="collapse bg-dark" id="navbarHeader">
        <div class="container">
          <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
              <p class="text-white" style="padding-top:2%;">Pour valider un challenge il faut trouver un flag (un mot de passe) qui est fourni dans chaque épreuve.</p>
              <p class="text-white">La plupart du temps les flags sont de la forme : {flag}. Si le flag ne respecte pas cette norme il faut valider avec le texte trouvé et respecter la casse!</p>
              <p class="text-white">A vos marques... Prêts... Hackez! ;)</p>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="d-flex justify-content-between">
          <a href="#" class="navbar-brand align-items-center">
            <a href="index.php?page=register.php">
              <strong class="menu_text">Register</strong>
            </a>
            <a href="index.php?page=login.php">
              <strong class="menu_text">Login</strong>
            </a>
            <a href="index.php?page=logout.php">
              <strong class="menu_text">Logout</strong>
            </a>
          </a>
        </div>
        <div class="d-flex justify-content-between">
          <a href="index.php">
            <img src="img/logo-conserto.png" style="max-width: 100%; height: 20px "> 
          </a>
        </div>
            <!-- <strong>Toto</strong> -->
        <div class="d-flex justify-content-between">
          <a href="index.php?page=tools.php">
            <strong class="menu_text">Tools</strong>
          </a>
          <a class="nav-link dropdown-toggle" href="#" id="ChallengesDropdown"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 0 0 !important">
            <strong class="menu_text">Challenges</strong>
          </a>
          <div class="dropdown-menu" aria-labelledby="ChallengesDropdown" style="margin-left: 80%;">
            <?php
              require_once("class/secu_domains.php");
              $secu_domains = new Secu_domains;
              $secu_domains->create_navbar_challs();
            ?>
          </div>
          <a href="index.php?page=scores.php">
            <strong class="menu_text">Scores</strong>
          </a>
          <strong class="menu_text" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">Rules</strong>
        </div>
      </div>
    </header>

<?php

    if ( !isset($_SESSION["team"]) || empty($_SESSION["team"]) ) {
      if (isset($_GET["page"]) && ($_GET["page"]=="register.php" || $_GET["page"]=="login.php") ) {
        include $_GET["page"];
      }
    } else {
      //include "sidebar.php";
      if (! isset($_GET["page"]) || empty($_GET["page"]) ) {
        include "menu.php";
        
      } else {
        //include "sidebar.php";
        include $_GET["page"];
      }
    }
?>

    <footer class="text-muted">

    </footer>
  </body>
</html>
