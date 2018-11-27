<div class="row content">
  <?php
/** 
 * Page d'accueil de l'application web AppliFrais
 * @package default
 * @todo  RAS
 */

$repInclude = './include/';
require($repInclude . "_init.inc.php");

  // page inaccessible si visiteur non connecté
if (!estVisiteurConnecte()) 
{
  header("Location:cSeConnecter.php");  
}
require($repInclude . "_entete.inc.html");
require($repInclude . "_sommaire.inc.php");



?>
<!-- Division principale -->
<div class="col-lg-9">
  <h2>Bienvenue sur l'intranet GSB pour les visiteurs</h2>
</div>
</div>
<?php 
require($repInclude . "_pied.inc.html");
require($repInclude . "_fin.inc.php");

?>
