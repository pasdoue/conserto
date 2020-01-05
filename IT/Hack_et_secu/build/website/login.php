<?php

require_once('class/secu_domains.php');

//verify user is authenticated
if (isset($_SESSION['team']) && !empty($_SESSION['team'])) {
    header("Location: index.php");
} else {
    if (isset($_POST["team_name"]) && $_POST["team_name"] && isset($_POST["password"]) && $_POST["password"]) {
        $team = new Team($_POST["team_name"], $_POST["password"]);
        $team_name = $team->get_name();

        if (isset($team_name) && !empty($team->get_name())) {
            $_SESSION["team"] = serialize($team);
            echo "
            <main role=\"main\" class=\"container\" style=\"padding-top: 5%;\">
                <div class=\"alert alert-success\" role=\"alert\">
                    All right! Successfully logged in ;)
                </div>
            </main>";
        } else {
            echo "
            <main role=\"main\" class=\"container\" style=\"padding-top: 5%;\">
                <div class=\"alert alert-danger\" role=\"alert\">
                    Invalid credentials.
                </div>
            </main>";
        }
    }
}



?>


<main role="main" class="container" style="padding-top: 5%;">
    
    <div class="jumbotron">
        <h3 style="padding-left: 45%;">Login</h3>
        <form method="post" action="index.php?page=login.php">
            <div class="form-group">
                <label for="team_name">Team name :</label>
                <input type="text" class="form-control" name="team_name" id="team_name" placeholder="Team name">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                <small id="passwordHelp" class="form-text text-muted">Don't share your password</small>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</main>


<div class="container">
    
    
</div>
