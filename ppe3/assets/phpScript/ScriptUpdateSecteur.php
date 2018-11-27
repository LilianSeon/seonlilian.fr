<?php
require 'ScriptBDD.php';
echo '<pre>';

$bdd = new BDD();

$bdd->query('UPDATE visiteur 
                   JOIN travailler ON travailler.VIS_MATRICULE = visiteur.VIS_MATRICULE
                   JOIN region     ON region.REG_CODE = travailler.REG_CODE
                    SET visiteur.SEC_CODE = region.SEC_CODE
                     WHERE visiteur.VIS_MATRICULE = travailler.VIS_MATRICULE
                   ');

$row = $bdd->resultset();

print_r($row);












echo '</pre>';