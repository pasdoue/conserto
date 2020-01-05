
<?php
    require_once('class/secu_domains.php');

    if (isset($_POST["team_name"]) && $_POST["team_name"] && isset($_POST["password"]) && $_POST["password"]) {
        $team = new Team($_POST["team_name"], $_POST["password"]);
        if ($team->already_exists_team_name($_POST["team_name"])) {

            echo "
            <main role=\"main\" class=\"container\" style=\"padding-top: 5%;\">
                <div class=\"alert alert-danger\" role=\"alert\">
                    Team name (".$team->team_name.") already registered. Please chose another one
                </div>
            </main>";
        } else {
            $team->create($_POST["team_name"], $_POST["password"]);
            header("Location: index.php?page=login.php");
        }
    }

?>

<main role="main" class="container" style="padding-top: 5%;">
    
    <div class="jumbotron">
        <h3 style="padding-left: 45%;">Register</h3>
        <form method="post" action="index.php?page=register.php">
            <div class="form-group">
                <label for="team_name">Team name :</label>
                <input type="text" class="form-control" name="team_name" id="team_name" placeholder="Team name">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                <small id="passwordHelp" class="form-text text-muted">Don't share your password</small>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main>




