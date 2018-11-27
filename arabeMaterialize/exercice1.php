<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Alphabet Arabe</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
     <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>

</head>
<body>
<?php

require("fonctionPHP/fonction.php");
$nb = NbrRandom();
if (!isset($_GET['com'])) {
  $combo = 0;
}

$fail = 0;
?>
<div class="container">

   <ul id="slide-out" class="side-nav fixed">
      <center><div class="background">
        <img src="images/logo.png">
      </div></center>
      <hr>
      <li class="red lighten-2"><a href="/arabeMaterialize/exercice1.php"><i class="material-icons">mode_edit</i>Exercice n°1</a></li>
      <li><a href="/arabeMaterialize/index.php"><i class="material-icons">sort_by_alpha</i>Lettres Arabe</a></li>
      <li><a href="/arabeMaterialize/regle.php"><i class="material-icons">list</i>Les règles</a></li>
      <li><div class="divider"></div></li>
      <li><a href="/arabeBootstrap/index.php"><i class="material-icons">code</i>Alphabet arabe Bootstrap</a></li>
    </ul>
  <div class="col s6 l6 offset-s6 offset-l6 right-align">
    <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
  </div>
    <script type="text/javascript">
    $(".button-collapse").sideNav();
    </script>
<center><h2>Exercice n°1</h2>

    <!-- Modal Trigger -->
  <a class="waves-effect waves-light btn" href="#modal1">Règles du jeu</a>

  <!-- Modal Structure -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <h4>Règles du jeu :</h4>
      <p>Écrivez le nom de la lettre en français correspondant à l'image.<br/>
      Si jamais vous obtenez une mauvaise réponse, passez votre souris sur la lettre pour afficher l'aide.</p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">OK</a>
    </div>
  </div>

  <center>
    <?php
    if (isset($_GET['cor']) && $_GET['cor'] == 'true') {
      ?>
      <script type="text/javascript">
      Materialize.toast('<span class="green-text text-darken-2">Bonne réponse ! <i class="material-icons">done</i></span>', 6000)
      </script>
      <?php
    }

    if (isset($_GET['cor']) && $_GET['cor'] == 'false') {
      $nb = $_GET['nb'];
      $fail = 1;
      ?>
      <script type="text/javascript">
      Materialize.toast('<span class="red-text text-darken-2">Mauvaise réponse ! <i class="material-icons">warning</i></span>', 6000)
      </script>
      <?php
    }
    ?>
    <img class="tooltipped" data-position="right" data-delay="50" data-tooltip="<?php if($fail == 1){ echo Helper($nb);}?>" style="margin-top:5%" src="alphabet/<?= $nb ?>.PNG" alt="Lettre arabe">
<form  class="col s12 m9" method="POST" action="ex1correction.php">
  <div class="row" style="margin-top:2%">
  <div class="col s4"></div>
    <div class="input-field col s3 ">
          <input id="msg" name="msg" type="text" class="validate" autofocus>
          <label for="msg">Lettre :</label>
    </div>
    <div class="col s5 m2">
    <span class="input-group-btn">
    <button style="margin-top:12%;" class="btn waves-effect waves-light red lighten-2" type="submit" name="action"><i class="material-icons right">send</i>OK</button>
    </span>
  </div>
    
    <input type="hidden" name="nombre" value="<?=$nb?>">
    <input type="hidden" name="combo" value="<?php if(isset($_GET['com'])){ echo $_GET['com'];}else{echo $combo;}?>">
</form>
</div>
  <div class="row" style="font-family: 'Orbitron', cursive; font-size:200%;">
    <div class="col s3 m4"></div>
      <div class="col s7 m3">
                <div class="card-panel red lighten-2 z-depth-3 center-align">
          <span class="white-text">
Combo : <?php if (!isset($_GET['com'])) {
    echo "0";
}else {
  echo $_GET['com'];
}?>
          </span>
        </div>

</div>

</center>

</div>


        <footer style="margin-top:11%" class="page-footer">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">Alphabet Materialize</h5>
                <p class="grey-text text-lighten-4"></p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Menu</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="/arabeMaterialize/exercice1.php">Exercice n°1</a></li>
                  <li><a class="grey-text text-lighten-3" href="/arabeMaterialize/index.php">Lettres Arabe</a></li>
                  <li><a class="grey-text text-lighten-3" href="/arabeMaterialize/regle.php">Les règles</a></li>
                  <li><a class="grey-text text-lighten-3" href="/arabeBootstrap/index.php">Alphabet arabe Bootstrap</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2017 Copyright Séon Lilian
            <a class="grey-text text-lighten-4 right" href="www.seonlilian.fr">Home</a>
            </div>
          </div>
        </footer>
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
  $(document).ready(function(){
    // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
  });
</script>
</body>
</html>