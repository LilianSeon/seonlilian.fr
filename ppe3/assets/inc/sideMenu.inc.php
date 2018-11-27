<?php
session_start();
require '../phpClass/ClassUser.php';
require_once '../phpScript/ScriptBDD.php';
$user = new User($_SESSION['id']);
?>
<ul id="slide-out" class="side-nav fixed">
    <li class="center-align">Bienvenue <span class="boldPoppins"><?= $user->getPrenom(); ?></span></li>
    <li><img src="../img/logoDefault.png" class="responsive-img center-block" width="150" alt=""></li>
    <li class="boldPoppins semiApadding">Comptes rendus</li>
    <li><a href="nouveauCR.php">Nouveaux</a></li>
    <li><a href="consulterCR.php">Consulter</a></li>
    <hr>
    <li class="boldPoppins semiApadding">Consulter</li>
    <li><a href="medicament.php">Médicaments</a></li>
    <li><a href="praticienCR.php">Praticiens</a></li>
    <li><a href="autreVisiteurCR.php">Autres visiteurs</a></li>
    <hr>

    <li><a href="../phpScript/ScriptDeco.php">Déconnexion</a></li>
</ul>
<a href="#" data-activates="slide-out" class="button-collapse"><i id="menuButton" class="fa fa-bars"></i></a>