<?php
/**
 * Contient la division pour le sommaire, sujet à des variations suivant la
 * connexion ou non d'un utilisateur, et dans l'avenir, suivant le type de cet utilisateur
 * @todo  RAS
 */

?>
<!-- Division pour le sommaire -->
<div class="col-lg-3">
 <div class="row panel panel-default">
   <div class="col-lg-12 panel-heading">
    <?php
    if (estVisiteurConnecte() ) {
      $idUser = obtenirIdUserConnecte() ;
      $lgUser = obtenirDetailVisiteur($idCnx, $idUser);
      $nom = $lgUser['nom'];
      $prenom = $lgUser['prenom'];
      ?>
      <h2>
        <?php
        echo $nom . " " . $prenom ;
        ?>
      </h2>
      <h3>Visiteur médical</h3>
      <?php
    }
    ?>
  </div>

  <?php
  if (estVisiteurConnecte() ) {
    ?>
    <div class="col-lg-12 panel-body">
      <ul class="nav nav-pills nav-stacked">
       <li class="active">
        <a href="cAccueil.php" title="Page d'accueil">Accueil</a>
      </li>
      <li>
        <a href="cSeDeconnecter.php" title="Se déconnecter">Se déconnecter</a>
      </li>
      <li>
        <a href="cSaisieFicheFrais.php" title="Saisie fiche de frais du mois courant">Saisie fiche de frais</a>
      </li>
      <li>
        <a href="cConsultFichesFrais.php" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
      </li>
    </ul>
  </div>
  <?php
          // affichage des éventuelles erreurs déjà détectées
  if (nbErreurs($tabErreurs) > 0 ) {
    echo toStringErreurs($tabErreurs) ;
  }
}
?>
</div>
</div>
