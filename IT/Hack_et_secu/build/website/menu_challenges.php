<?php
    if ( ! isset($_GET["domain"]) || empty($_GET["domain"])) {
        header("Location: index.php");
    }
?>

<main role="main">

  <section class="jumbotron text-center">
    <div class="container">
      <h1 class="jumbotron-heading">Challenges Conserto!</h1>
      <p class="lead text-muted">Pour une petite introduction à l'environnement des CTF et la découverte du hacker qui est en vous ;)</p>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">

      <div class="row">

        <?php
            $secu_domains->create_menu_challs($_GET["domain"]);
        ?>

      </div>
    </div>
  </div>

</main>
