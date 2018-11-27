<?php 
require("fonctionPHP/fonction.php");
$nombre = $_POST['nombre'];
$message = $_POST['msg'];
$combo = $_POST['combo'];
$resultat = CorrectionEx1($nombre, $message);
if ($resultat == "true") {
	$combo++;
}else{
	$combo = 0;
}
$url = "exercice1.php?nb=$nombre&cor=$resultat&com=$combo";
header("Location: $url");
?>