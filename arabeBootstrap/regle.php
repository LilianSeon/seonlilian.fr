<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Alphabet Arabe</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

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

<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Règle n°1</a></li>
    <li><a data-toggle="tab" href="#menu1">Règle n°2</a></li>
</ul>
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <div class="view">
    <h3 contenteditable="true">Les six lettres suivantes :</h3>
  </div>
  <table class="table table-bordered" contenteditable="true">
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
      <div class="view">
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

</body>
</html>