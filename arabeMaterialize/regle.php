<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Alphabet Arabe</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/style.css" rel="stylesheet" type="text/css">
   <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>

<div class="container">
  <nav>
    <div class="nav-wrapper">
      <a href="/arabeMaterialize/index.php" class="brand-logo">Alphabet Arabe</a>
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="/arabeBootstrap/index.php">Alphabet Arabe Bootstrap</a></li>
        <li><a href="regle.php">Les Règles</a></li>
        <li><a href="exercice1.php">Exercice n°1</a></li>
      </ul>
      <ul class="side-nav" id="mobile-demo">
        <li><a href="/arabeBootstrap/index.php">Alphabet Arabe Bootstrap</a></li>
        <li><a href="regle.php">Les Règles</a></li>
        <li><a href="exercice1.php">Exercice n°1</a></li>
      </ul>
    </div>
  </nav>
  <div class="row">
    <div class="col s12">
      <ul class="tabs">
        <li class="tab col s4"><a class="active" href="#home">Règle n°1</a></li>
        <li class="tab col s4"><a  href="#menu1">Règle n°2</a></li>
      </ul>
    </div>
  </div>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <div class="view">
    <h3 contenteditable="true">Les six lettres suivantes :</h3>
  </div>
  <table class="striped" contenteditable="true">
    <thead>
    </thead>
      <tbody>
        <tr>
          <td class="Bold2">و</td>
          <td class="Bold2">ز</td>
          <td class="Bold2">ر</td>
          <td class="Bold2">ذ</td>
          <td class="Bold2">د</td>
          <td class="Bold2">ﺍ</td>
        </tr>
      </tbody>
    </table>
    <div class="view">
    <p contenteditable="true"><strong>ne s’attachent jamais</strong> avec la lettre, ou la voyelle longue, qui les suit.</p>
  </div>
</div>

<div id="menu1" class="tab-pane fade">
      <div >
        <h3 contenteditable="true">Doublement de la lettre - La chedda : ّ</h3>
        <p contenteditable="true">le doublement de la lettre – consonne – c’est-à-dire lorsqu’une lettre arabe portant un soukoune et suivie par une même lettre arabe portant une voyelle: bba = بْ+ بَ.</p>
      </div>

      <table class="table table-bordered">
    <thead>
      <tr>
        <th>Mot arabe</th>
        <th>Traduction</th>
        <th>Phonétique</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="Bold2">قِطَّةٌ <audio controls="controls">
  Votre navigateur ne prend pas en charge l'élément <code>audio</code>.
  <source src="audio/chedda.mp3" type="audio/wav">
</audio></td>
        <td>chat</td>
        <td class="Bold">Qiŧŧatun</td>
      </tr>
    </tbody>
  </table>
</div>


</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript">
$(".button-collapse").sideNav();
</script>
</body>
</html>