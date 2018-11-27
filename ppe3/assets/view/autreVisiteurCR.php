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
<?php include '../inc/sideMenu.inc.php';?>
<main>
    <div class="row">
        <div class="col l10 m10 s10 offset-l1">
            <h5>Visiteurs</h5>
            <div class="col l5 m6 s12">
                <input id="recherche" placeholder="Rechercher un visiteur"/>
            </div>
        </div>
        <div class="row">
            <div class="col l7 offset-l1 offset-m0 s12">
                <?php
                //require '../phpScript/ScriptBDD.php';
                require '../phpClass/ClassVisiteur.php';
                ?>
                <?php foreach(Visiteur::getAllVisiteurs() as $value):?>
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <h4 class="nom">
                                <?php echo mb_strtoupper($value->getNom(),'UTF-8')." ".$value->getPrenom(); ?>
                            </h4>
                        </li>
						<li class="collection-item">
							<h6 class="boldPoppins">
								Matricule :
								<span class="softPoppins">
                                <?php echo $value->getMatricule(); ?>
                            </span>
							</h6>
						</li>
						<li class="collection-item">
                            <h6 class="boldPoppins">
                                Adresse :
                                <span class="softPoppins">
                                <?php echo $value->getAdresse(); ?>
                            </span>
                            </h6>
                        </li>
                        <li class="collection-item">
                            <h6 class="boldPoppins">
                                Ville :
                                <span class="softPoppins">
                                 <?php echo $value->getCp()." ".$value->getVille(); ?>
                            </span>
                            </h6>
                        </li>
                        <li class="collection-item">
                            <h6 class="boldPoppins">
                                Secteur :
                                <span class="softPoppins">
                               <?php echo $value->getSecteur()->getSecLibelle(); ?>
                            </span>
                            </h6>
                        </li>
                        <li class="collection-item">
                            <h6 class="boldPoppins">
                                Labo :
                                <span class="softPoppins">
                                <?php echo $value->getLabo()->getLabNom(); ?>
                            </span>
                            </h6>
                        </li>
                    </ul>
                <?php endforeach;?>
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