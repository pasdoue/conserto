
<div style="overflow: auto">
    <table class="table" style="margin-top:5%;">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Equipes</th>
      <th scope="col">Score</th>


<?php
    //retrieve all challs objects
    $challs_obj = array();
    foreach ($secu_domains->domains as $key_domain => $domain) {
        if ($domain->is_written() == FALSE) {
            continue;
        }
        foreach ($domain->get_challs() as $chall) {
            $challs_obj[] = $chall;
            //echo "<th scope=\"col\" class=\"verticaltext\">$chall</th>";
            $chall_short_name = explode('.', $chall->get_name());
            echo "<th scope=\"col\">".$chall_short_name[0]."</th>";
        }
    }

?>
    </tr>
  </thead>
  <tbody>
<?php
    $chall_picture_validated = "<td><img class=\"chall_ok_nok mx-auto d-block\" src=\"img/chall_ok.png\"/></td>";
    $chall_picture_not_validated = "<td><img class=\"chall_ok_nok mx-auto d-block\" src=\"img/chall_nok.png\"/></td>";

    $req = "SELECT * FROM team";
    foreach ( $bdd->get_hanlder()->query($req) as $team ) {

        $validated_challs_id=array();

        echo "<tr>
                <th scope=".$team['name'].">".$team['name']."</th>";
        echo    "<td id=\"score_".$team['name']."\" style=\"text-align: center;\">".$team['score']."</td>";

            $req2 = "SELECT * FROM chall_team_tern WHERE id_team=".$team['id'];
            foreach ( $bdd->get_hanlder()->query($req2) as $tern ) {
                $validated_challs_id[] = $tern['id_chall'];
            }
            foreach ($challs_obj as $chall_obj) {
                if ( in_array($chall_obj->get_chall_id(), $validated_challs_id) ) {
                    echo $chall_picture_validated;
                } else {
                    echo $chall_picture_not_validated;
                }
            }
        echo "</tr>";
    }
?>
    </tr>
  </tbody>
</table>

</div>
