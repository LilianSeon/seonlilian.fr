<!DOCTYPE HTML>
<html>
<head>
    <title>GSB - Comptes-Rendus</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="../css/main.css" media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="../css/font-awesome.min.css" media="screen,projection"/>
</head>

<body>
<?php include '../inc/sideMenu.inc.php'; ?>
<main>
    <div class="row">
        <div class="col l10 m10 s10 offset-l1">
            <h5>Praticiens</h5>
            <div class="col l5 m6 s12">
                <input id="recherche" placeholder="Rechercher un practicien"/>
            </div>
        </div>
        <div class="row">
            <div class="col l7 offset-l1 offset-m0 s12">
                <?php
                  //require '../phpScript/ScriptBDD.php';
                  require '../inc/getAllPraticien.inc.php';
                ?>
                </div>
        </div>
    </div>
</main>


<script src="../js/jquery.min.js"></script>
<script src="../js/materialize.min.js"></script>
<script src="../js/main.js"></script>
<script src="../js/recherche.js"></script>
</body>
</html>