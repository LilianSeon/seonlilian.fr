<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Alphabet Arabe</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Covered+By+Your+Grace" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php

require("fonctionPHP/fonction.php");
$nb = NbrRandom();
if (!isset($_GET['com'])) {
  $combo = 0;
}

$fail = 0;;
?>

<div class="container">

  <div id="custom-bootstrap-menu" class="navbar navbar-default " role="navigation">
    <div class="container-fluid">
        <div class="navbar-header"><a class="navbar-brand" href="index.php">Alphabet</a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse navbar-menubuilder">
            <ul class="nav navbar-nav navbar-left">
              <li><a href="/arabeMaterialize/index.php">Alphabet Arabe Materialize</a></li>
                <li><a href="regle.php">Les Règles</a>
                </li>
                <li><a href="exercice1.php">Exercice 1</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<br/>

<center><h2>Exercice n°1</h2>

  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Règle du jeu</button></center>

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Règle :</h4>
        </div>
        <div class="modal-body">
          <p>Écrivez le nom de la lettre en français correspondant à l'image.<br/>
            Si jamais vous obtenez une mauvaise réponse, passez votre souris sur la lettre pour afficher l'aide.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <center>
    <?php
    if (isset($_GET['cor']) && $_GET['cor'] == 'true') {
      ?>
      <br/>
      <div class="row">
        <div class="alert alert-success col-md-4 col-md-offset-4 col-xs-8 col-xs-offset-2">
          <strong>Success !</strong> Right answer.
        </div>
      </div>
      <?php
    }

    if (isset($_GET['cor']) && $_GET['cor'] == 'false') {
      $nb = $_GET['nb'];
      $fail = 1;
      ?>
      <br />
        <div class="row">
          <div class="alert alert-danger col-md-4 col-md-offset-4 col-xs-8 col-xs-offset-2">
            <strong>Defeat !</strong> You should try again.
          </div>
        </div>
      <?php
    }
    ?>
    <img style="margin-top:5%" data-toggle="tooltip" title="<?php if($fail == 1){ echo Helper($nb);}?>" src="alphabet/<?= $nb ?>.PNG" alt="Lettre arabe">
<form method="POST" action="ex1correction.php">
  <div class="row">
  <div style="margin-top:2%" class="input-group col-md-3 col-xs-7">
    <span class="input-group-addon">Texte</span>
    <input id="msg" type="text" class="form-control" name="msg" placeholder="Nom de la lettre" autofocus>
    <span class="input-group-btn">
  <button type="submit" class="input-group btn btn-default">OK</button>
</span>
    </div>

    <input type="hidden" name="nombre" value="<?=$nb?>">
    <input type="hidden" name="combo" value="<?php if(isset($_GET['com'])){ echo $_GET['com'];}else{echo $combo;}?>">
</form>
</div>
  <div style="font-family: 'Covered By Your Grace', cursive; font-size:200%;">
Combo : <?php if (!isset($_GET['com'])) {
    echo "0";
}else {
  echo $_GET['com'];
}?>
</div>
</center>

</div>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
</body>
</html>