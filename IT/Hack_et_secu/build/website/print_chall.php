
<main role="main" class="container" style="padding-top: 125px;">
    
    <div class="jumbotron">
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModalCenter">Indice ?</button>

<?php

$chall_name = $_GET["chall_name"];
$chall_cat = $_GET["chall_cat"];

$secu_domains->print_chall($chall_name, $chall_cat);
$hint = $secu_domains->get_chall_hint($chall_name, $chall_cat);
?>
        <p class="lead" style="border-bottom: 2px solid #dee2e6 !important; margin-bottom:2em;"></p>
        <div>
            <div class="form-group">
                <input style="width: 25%;" type="password" class="form-control" id="resp" placeholder="Flag juste ici ! :D">
            </div>
            <button type="submit" id="sol_chall" class="btn btn-primary" style="background-color: #ff85ed;">Valider</button>
        </div>
    </div>
</main>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Indice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo $hint; ?>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    var exec_code = function(){
        $.ajax({
            type: "POST",
            url: "get_solution.php?",
            data: { 
                chall_name: "<?php echo $chall_name; ?>", 
                chall_cat: "<?php echo $chall_cat; ?>", 
                resp: $('#resp').val()
            },
            dataType: "json",
            success: function(data) {
                if (data == null ) { 
                    alert("Error"); 
                } else {
                    if (data == 0) {
                        alert("Challenge validé! héhé");
                    } else {
                        alert("Dommage ce n'est pas le bon flag! :( Courage!");
                    }
                }
            },
            error: function(jqxhr, status, exception) {
                //I think as we have to change the session infos when we validate the challenge, then it produces an erreor with javascript handler and then produce error.
                //alert("Challenge validé! héhé");
                alert('Error occured: ', exception, 'status : ',status);
            }
        });
    };
    $('#sol_chall').click(exec_code);
    $('#resp').keydown(function (e){
        if(e.keyCode == 13){
            exec_code();
        }
    })
</script>


