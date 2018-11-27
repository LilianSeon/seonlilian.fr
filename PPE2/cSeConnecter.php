<?php  
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Se connecter"
 * @package default
 * @todo  RAS
 */
$repInclude = './include/';
require($repInclude . "_init.inc.php");

  // est-on au 1er appel du programme ou non ?
$etape=(count($_POST)!=0)? 'validerConnexion' : 'demanderConnexion';

  if ($etape =='validerConnexion') { // un client demande à s'authentifier
      // acquisition des données envoyées, ici login et mot de passe
  $login = lireDonneePost("txtLogin");
  $mdp = lireDonneePost("txtMdp");

      //Cryptage du mot de passe entrer par l'utilisateur en MD5
      //$mdp = md5($mdp);

  $lgUser = verifierInfosConnexion($idCnx, $login, $mdp) ;
      // si l'id utilisateur a été trouvé, donc informations fournies sous forme de tableau
  if ( is_array($lgUser) ) { 
    affecterInfosConnecte($lgUser["id"], $lgUser["login"]);
  }
  else {
    ajouterErreur($tabErreurs, "Pseudo et/ou mot de passe incorrects");
  }
  $type = verifierType($idCnx, $login, $mdp);
}
if ($etape == "validerConnexion" && nbErreurs($tabErreurs) == 0 && $type == 1) {
  header("Location: cAccueil.php");
}
if ($etape == "validerConnexion" && nbErreurs($tabErreurs) == 0 && $type == 2) {
  header("Location: comptable.php");
}

require($repInclude . "_entete.inc.html");
require($repInclude . "_sommaire.inc.php");
?>
<!-- Division pour le contenu principal -->
<div class="col-lg-9">
  <div class="login-panel panel panel-default">
    <h2 class="panel-heading"><p>Identification utilisateur<p></h2>
    <?php
    if ( $etape == "validerConnexion" ) 
    {
      if ( nbErreurs($tabErreurs) > 0 ) 
      {
        echo toStringErreurs($tabErreurs);
      }
    }
    ?>               
    <div class="panel-body">
      <form action="" method="post">
        <fieldset>
          <div class="form-group">
            <label for="txtLogin" accesskey="n">* Login : </label>
            <input class="form-control" type="text" name="txtLogin" maxlength="20" size="15" value="" title="Entrez votre login" />
          </div>
          <div class="form-group">
            <label for="txtMdp" accesskey="m">* Mot de passe : </label>
            <input class="form-control" name="txtMdp" maxlength="8" type="password" size="15" value=""  hidden title="Entrez votre mot de passe"/>
          </div>
          <input class="btn btn-primary" type="submit"  value="valider"/>
          <input class="btn btn-primary" type="reset"  value="Effacer"/>
        </fieldset>
      </form>
    </div>
  </div>
</div>
<?php
require($repInclude . "_pied.inc.html");
require($repInclude . "_fin.inc.php");
?>