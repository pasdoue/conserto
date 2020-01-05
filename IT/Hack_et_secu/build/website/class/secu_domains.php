<?php

class BDD
{
    private $handler = null;
    private $bdd_type = "mysql";
    private $host = "localhost";
    private $username = "pinkhat";
    private $passwd = "FgTyJ1kd29!,";
    private $dbname = "conserto_challs";

    public function __construct() {
        try {
            $this->handler = new PDO(
                $this->bdd_type .':host='. $this->host .';dbname='. $this->dbname, 
                $this->username, 
                $this->passwd,
                //enforce PDO to retrieve UTF8 encoding char to avoid weird printing behavior
                //because print non retrievable chars even if BDD default charset is UTF8...
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
            $this->handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('Erreur : '. $e->getMessage());
        }
    }

    public function get_hanlder() {
        return $this->handler;
    }
}

$bdd = new BDD;

class Chall
{
    public $chall_id;
    public $name;
    public $description;
    public $hint;
    public $solution;
    public $level;
    public $points;

    function __construct($chall_id, $name, $description, $solution, $points=0, $hint="", $level="easy") {
        $this->chall_id = $chall_id;
        $this->name = $name;
        $this->description = $description;
        $this->solution = $solution;
        $this->hint = $hint;
        $this->level = $level;
        $this->points = $points;
    }

    function get_chall_id() { return $this->chall_id; }
    function get_name() { return $this->name; }
    function get_description() { return $this->description; }
    function get_solution() { return $this->solution; }
    function get_hint() { return $this->hint; }
    function get_level() { return $this->level; }
    function get_points() { return $this->points; }
}

class Domain
{
    public $domain_id;
    public $name;
    public $css_class;
    public $written;
    public $image_format;
    public $challs = array();
    public $bdd_handler;


    function __construct($name) {
        global $bdd;

        $req = "SELECT * FROM domains WHERE name LIKE '".$name."'";
        foreach ( $bdd->get_hanlder()->query($req) as $row ) {
            $this->name = $row['name'];
            $this->css_class = $row['css_style'];
            $this->written = $row['written'] == 1 ? TRUE : FALSE;
            $this->image_format = $row['image_format'];
            $this->domain_id = $row['id'];
        }

        $req = "SELECT * FROM chall WHERE domain_id = ".$this->domain_id;
        foreach ( $bdd->get_hanlder()->query($req) as $row ) {
             $this->challs[$row['name']] = new Chall(
                $row['id'], 
                $row['name'], 
                $row['description'], 
                $row['solution'], 
                $row['points'], 
                $row['hint'], 
                $row['level']
            );
         }
    }

    function get_name() { return $this->name; }
    function get_css_class() { return $this->css_class; }
    function is_written() { return $this->written; }
    function get_image_format() { return $this->image_format; }
    function get_challs() { return $this->challs; }

    function add_chall(Chall $chall) {
        $item = $this->challs[$chall->get_name()];
        if (isset($item)) {
            throw new Exception("challenge "+$chall->get_name()+" already exists");
        } else {
            $item = $chall;
        }
    }

    /*function del_chall(Chall $chall) {
        $item = $this->challs[$chall->get_name()];
        if (isset($item)) {
            unset($item);
        } else {
            throw new Exception("challenge "+$chall->get_name()+" does not exists. Cannot be removed");
        }
    }*/

    function get_chall($chall_name) {
        $item = $this->challs[$chall_name];
        if (!isset($item)) {
            throw new Exception("challenge "+$chall_name+" does not exists. Cannot be retrieved");
        } else {
            return $item;
        }
    }
}

/**
 * Class to print menu for all secu domains
 */
class Secu_domains
{
    public $domains = array();

    function __construct() {
        global $bdd;
        $req = "SELECT * FROM domains";
        foreach ( $bdd->get_hanlder()->query($req) as $row ) {
             $this->domains[$row['name']] = new Domain( $row['name'] );
        }
        //echo "<pre>"; print_r($this->domains) ; echo "</pre>";
    }

    public function create_menu()
    {
        foreach ($this->domains as $domains_infos) {
            if ($domains_infos->is_written() == TRUE) {
                echo "
                <div class=\"col-md-4\">
                  <div class=\"card mb-4 shadow-sm\">
                    <a href=\"index.php?page=menu_challenges.php&domain=",$domains_infos->get_name(),"\">
                        <img class=\"image_secu_domain\" src=\"img/",$domains_infos->get_name(),".",$domains_infos->get_image_format(),"\">
                    </a>
                    <div class=\"card-body\">
                      <a href=\"index.php?page=menu_challenges.php&domain=",$domains_infos->get_name(),"\">
                        <p class=\"", $domains_infos->get_css_class() ,"\">Epreuves de ",$domains_infos->get_name(),"</p>
                      </a>
                      <div class=\"d-flex justify-content-between align-items-center\">
                      </div>
                    </div>
                  </div>
                </div>";
            }
        }
    }

    public function create_navbar_challs()
    {
        foreach ($this->domains as $domains_infos) {
            if ($domains_infos->is_written() == TRUE) {
                echo "
                <a class=\"dropdown-item\" href=\"index.php?page=menu_challenges.php&domain=",$domains_infos->get_name(),"\">",$domains_infos->get_name(),"</a>";
            }
        }
    }

    public function create_menu_challs($challenge_category)
    {
        echo "
        <table class=\"table table-striped\">
          <thead>
            <tr>
              <th scope=\"col\">#</th>
              <th scope=\"col\">Nom du challenge</th>
            </tr>
          </thead>
          <tbody>";

        $i=0;
        foreach ($this->domains[$challenge_category]->challs as $chall_obj ) {
            $chall_name = $chall_obj->get_name();
            $short_chall_name = explode('.', $chall_obj->get_name())[0];
            $chall_level = $chall_obj->get_level();
            echo "
            <tr>
                <th scope=\"row\">".($i+1)."</th>
                <td> <a href=\"index.php?page=print_chall.php&chall_name=$chall_name&chall_cat=$challenge_category\">",$short_chall_name,"</a>
                <img alt=\"$chall_level\" class=\"float-right\" height=\"10%\" width=\"4%\" src=\"img/$chall_level.png\"></td>
            </tr>";
            $i++;
        }
        echo '
            </tbody>
        </table>';
    }

    public function print_chall($chall_name, $chall_cat)
    {
        $chall_obj = $this->domains[$chall_cat]->challs[$chall_name];

        if ( isset($chall_obj) ) {

            echo "<h2>".(pathinfo($chall_name,PATHINFO_FILENAME))."</h2>";
            echo "<p class=\"lead\" style=\"border-bottom: 2px solid #dee2e6 !important; margin-bottom:2em;\">".$chall_obj->get_description()."</p>";

            $file_path = "challs/".$chall_cat."/".$chall_name;
            if (!file_exists($file_path)) {
                return 0;
            }
            $file_parts = pathinfo($chall_name);

            switch($file_parts['extension'])
            {
                case "txt":
                    $text = file_get_contents($file_path);
                    echo $text;
                break;
                case "png":
                case "jpg":
                    echo "<img style=\"max-width: 100%;height: 100px;\" src='".$file_path."'>";
                break;
                case "wav":
                    echo 
                    "<object data = \"data/test.wav\" type = \"audio/x-wav\" width = \"200\" height = \"20\">
                       <param name = \"src\" value = \"".$file_path."\">
                       <param name = \"autoplay\" value = \"false\">
                       <param name = \"autoStart\" value = \"0\">
                       <a href = \"".$file_path."\">".$chall_name."</a>
                    </object>";
                    //echo '<embed type="video/webm" width="250" height="200" src="'.$file_path.'"  autostart="true"></embed>';
                break;
                case "html":
                    include($file_path);
                    break;

                default:
                    echo "<a href='".$file_path."'>".$chall_name."</a>";
                break;
            }
        }
    }

    public function get_chall_description($key_domain, $key_chall)
    {
        return $this->domains[$chall_cat]->challs[$chall_name]->get_description();
    }

    public function get_chall_hint($chall_name, $chall_cat)
    {
        return $this->domains[$chall_cat]->challs[$chall_name]->get_hint();
    }

    public function is_chall_solved($chall_name, $chall_cat, $chall_solution)
    {
        return strcmp($chall_solution, $this->domains[$chall_cat]->challs[$chall_name]->get_solution()) == 0 ? 0 : 1;
        //return $chall_solution." ".$this->domains[$chall_cat]->challs[$chall_name]->get_solution();
    }

    public function update_chall_solved_bdd($chall_name, $chall_cat, $team_id, $team_score)
    {
        global $bdd;
        $chall_points = $this->domains[$chall_cat]->challs[$chall_name]->get_points();
        $new_team_score = $team_score + $chall_points;
        $chall_id = $this->domains[$chall_cat]->challs[$chall_name]->get_chall_id();

        //verify first chall is not validated yet
        $query = $bdd->get_hanlder()->prepare("SELECT * FROM chall_team_tern WHERE id_chall = :id_chall AND id_team = :id_team");
        $query->bindParam(':id_chall', $chall_id);
        $query->bindParam(':id_team', $team_id);
        $query->execute();
        $count = $query->fetchColumn();

        if($count == 0) {
            $req = "INSERT INTO chall_team_tern (id_chall, id_team) VALUES (".$chall_id.", ".$team_id.")";
            $bdd->get_hanlder()->query($req);

            //update team points
            $req = "UPDATE team SET score = ".$new_team_score." WHERE id = ".$team_id;
            $bdd->get_hanlder()->query($req);
        }
    }
}



/**
 * 
 */
class Team
{
    public $team_id = 0;
    public $team_name = "";
    public $score = 0;
    public $challs_succeed = array();
    //private $bdd=NULL;

    function __construct()
    {
        global $bdd;
        $argc = func_num_args();
        $argv = func_get_args();
        //construct with team_name and password
        if ($argc == 2) {
            $team_name = $argv[0];
            $password = $argv[1];
            $req = "SELECT * FROM team WHERE name LIKE '".$team_name."' AND password LIKE '".$password."'";
        }
        //construct with team_id
        elseif ($argc == 1) {
            $team_id = $argv[0];
            $req = "SELECT * FROM team WHERE id = ".$team_id;
        } else {
            return;
        }
        foreach ( $bdd->get_hanlder()->query($req) as $row ) {
            $this->team_id = $row['id'];
            $this->team_name = $row['name'];
            $this->score = $row['score'];
        }
    }

    public function get_name() { return $this->team_name; }
    public function get_id() { return $this->team_id; }
    public function get_score() { return $this->score; }

    public function already_exists_team_name($team_name)
    {
        global $bdd;
        $req = "SELECT * FROM team WHERE name LIKE '".$team_name."'";
        foreach ( $bdd->get_hanlder()->query($req) as $row ) {
            if (isset($row['name']) && !empty($row['name'])) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function create($team_name, $password)
    {
        global $bdd;
        $req = "INSERT INTO team (`name`, `password`) VALUES ('".$team_name."', '".$password."');";
        $bdd->get_hanlder()->query($req);
    }

    public function get_all_chall_solved() {
        return;
    }
}



?>