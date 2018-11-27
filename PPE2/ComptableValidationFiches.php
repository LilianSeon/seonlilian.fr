<?php
//session_start();
/**
 * Script de contrôle et d'affichage du cas d'utilisation "Consulter une fiche de frais"
 * @package default
 * @todo  RAS
 */
$repInclude = './include/';
require($repInclude . "_init.inc.php");

  // page inaccessible si visiteur non connecté
if (!estVisiteurConnecte() ) {
	header("Location: cSeConnecter.php");
}
require($repInclude . "_entete.inc.html");
require($repInclude . "_sommaireC.inc.php");

$ChoixVisiteur = lireDonneePost('lstVisiteur');
$ChoixDate = lireDonneePost('mois_choix');

?>

<div class="col-lg-9">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h1>Valider les Fiches de frais</h1>
		</div>
		<?php
	//****************Cloture des fiches de tous les visiteurs en fonction de la date********************
	// Si le jour est supérieur au 10ème jour du mois
		if(date("d") > 8){
 	 // Récupération de la date du mois précédent dans la variable $date
			$m = date("m") - 1;
			if ($m < '10'){
   			 $date_de_Cloture =  date("Y") . "0" . $m; // On rajoute un 0 car le 0 s'enleve automatiquement quand on enleve 1 à $m.
   			}else{
    		$date_de_Cloture = date("Y").$m; // Si le mois est supérieur à 10 nous ne rajoutons pas de zéro pour éviter le 2016010 par exemple.
    	}
  		//Fonction permettant de cloturé les fiches en cours de création
    	Cloture_ficheVisiteur($idCnx, $date_de_Cloture);
    }
	//*****************************************************************************************
    ?>
    <div class="panel-body">
    	<form class="form-inline" method="post" action="">
    		<div class="form-group">
    			<!-- Liste déroulante avec le choix du visiteur dans un formulaire sans bouton-->
    			<label>Choisir le visiteur :</label>
    			<select name="lstVisiteur" class="zone">
    				<?php
       			// Affichage de la liste déroulante des visiteurs
    				Affichage_liste_deroulante($idCnx, $Choix_Visiteur);
    				?>
    			</select>
    		</div>
    		<div class="form-group">
    			<label>Choisir le mois :</label>
    			<select name='mois_choix'>
        <!--<?php
          // Affichage liste déroulante des mois disponible entre Janvier et le mois en cours
        choix_mois($Choix_Date);
        ?>-->
        <option value="01">Janvier</option>
        <option value="02">février</option>
        <option value="03">mars</option>
        <option value="04">avril</option>
        <option value="05">mai</option>
        <option value="06" selected>juin</option>
    			</select>
    		</div>
    		<div class="form-group">
    			<input class="btn btn-primary" type="submit" name="ChoixVisiteur" value="Voir la fiche"/>
    		</div>
    	</form>
    </div>
    <!-- <label class="titre">Mois :</label> <input class="zone" type="text" name="dateValid" size="12" value="<?php echo $date; ?>"/> -->
    <?php
			// Si on appui sur le bouton Choisir un visiteur
    if(isset($_POST["ChoixVisiteur"])){
  					// Récupération de l'ID du visiteur qu'à choisi l'utilisateur ainsi que du mois
    	$choixVisiteur = $_POST["lstVisiteur"];
    	$_SESSION['id_du_Visiteur'] = $choixVisiteur;
  					$date = date('Y') . $_POST['mois_choix']; //De la forme 201603 par exemple
  					$_SESSION['date'] = $date; //Pour l'utiliser en dehors du formulaire
  					$date_affichage = Transformation_Date_String($date);	
  					//Récupération des informations du visiteur
  					$Information_Visiteur = Recuperer_Information_Visiteur($idCnx, $_SESSION['id_du_Visiteur']);
            ?>


  					<div class="panel panel-default">
  						<div class="panel-heading">

  							<!-- Affichage du mois en cours -->
  							<h2>Fiche de frais du mois de <?= $date_affichage ?></h2>
  						</div>
  						<div class="panel-body">
  							<form method="post" action="">
  								<!--  Affichage des informations du visiteur -->
  								<p><strong>Nom : </strong><?= $Information_Visiteur['nom'] . " " .  $Information_Visiteur['prenom'] ?></p>
  								<p><strong>Adresse : </strong><?= $Information_Visiteur['adresse'] . ", " . $Information_Visiteur['cp'] . " " . $Information_Visiteur['ville'] ?></p>
  								<p>Embaucher dans l'entreprise depuis le <?= convertirDateAnglaisVersFrancais($Information_Visiteur['dateEmbauche']) ?> </p>
  								<?php
  				//Vérification de l'existance d'une fiche
  								$existe_Fiche_Frais = Existe_Fiche_Frais_NonValide($idCnx, $_SESSION['id_du_Visiteur'], $date);
  								if($existe_Fiche_Frais == false){
  									echo "<br>Aucune fiche présente pour ce visiteur ou la fiche à déjà été validée.";
  								}else{
					// *************PARTIE REQUETE POUR LES FRAIS EN FORFAIT******************
  					//Récupération des repas
  									$donneesRepas = Recup_frais_forfait($idCnx, $_SESSION['id_du_Visiteur'], $date, "REP");
  					//Récupération des nuitée
  									$donneesNuitee = Recup_frais_forfait($idCnx, $_SESSION['id_du_Visiteur'], $date, "NUI");
 					 //Récupération des Etapes
  									$donneesEtapes = Recup_frais_forfait($idCnx, $_SESSION['id_du_Visiteur'], $date, "ETP");
  					//Récupération des kilomètres
  									$donneesKilometre = Recup_frais_forfait($idCnx, $_SESSION['id_du_Visiteur'], $date, "KM");
  									?>

  									<h3>Frais au forfait </h3>
  									<div class="table-responsive">
  									<table class='table table-striped table-bordered'>
  										<tr>
  											<th>Repas midi</th>
  											<th>Nuitée </th>
  											<th>Etape</th>
  											<th>Km </th>
  											<th>Situation</th>
  										</tr>
  										<tr>
  											<td><input readonly="readonly" type="text"  name="repas" value="<?php echo $donneesRepas['quantite'] ?>"/></td>
  											<td><input readonly="readonly" type="text"  name="nuitee" value = "<?php echo $donneesNuitee['quantite'] ?>"/></td>
  											<td><input readonly="readonly" type="text"  name="etape" value = "<?php echo $donneesEtapes['quantite'] ?>"/></td>
  											<td><input readonly="readonly" type="text"  name="km" value = "<?php echo $donneesKilometre['quantite'] ?>"/></td>
  											<td>
  												<select size="3" name="situ">
  													<option value="V">Valider</option>
  													<option value="R">Refuser</option>
  												</select>
  											</td>
  										</tr>
  									</table>
  									</div>
  									<?php
					// ***************PARTIE POUR LES REQUETES HORS FORFAIT DES VISITEURS ET AFFICHAGE**************
  					//Vérification de l'existance de hors forfait
  									$existe_frais_horsForfait = Existe_frais_horsForfait($idCnx, $_SESSION['id_du_Visiteur'], $date);
  									if(!empty($existe_frais_horsForfait['libelle'])){
  						// Requete pour afficher les hors forfait
  										$requeteHF = "Select * from lignefraishorsforfait where idVisiteur = '$choixVisiteur' AND mois = '$date' ";
  										$reponseHF = mysqli_query($idCnx, $requeteHF);
 						 //Variable vide pour tester en phase de validation
  										$ValidationFicheHorsForfait = false;
  										?>
  										<h3>Hors Forfait</h3>
  										<div class="table-responsive">
  											<table class='table table-striped table-bordered'>
  												<tr>
  													<th>Date</th>
  													<th>Libellé </th>
  													<th>Montant</th>
  													<th>Situation</th>
  												</tr>
  												<?php
  												$i = 0;
      					$Tableau = array(); //Déclaration du tableau
      					$Lib = array();
      					// Tant qu'il y a des lignes à affiché
      					while($donneesHF = mysqli_fetch_assoc($reponseHF)){
      						$Lib[$i] = $donneesHF["libelle"];
      						?>
      						<tr>
      							<td><input readonly="readonly" type="text" name="hfDate1" value ="<?php echo$donneesHF['date'] ?>"/></td>
      							<td><input readonly="readonly" type="text" name="hfLib1" value ="<?php echo $Lib[$i] ?>"/></td>
      							<td><input readonly="readonly" type="text" name="hfMont1" value ="<?php echo $donneesHF['montant'] ?>"/></td>
      							<td>
      								<select name="situ_horsForfait[]">
      									<option value="V">Valider</option>
      									<option value="R">Refuser</option>
      								</select>
      							</td>
      						</tr>
      					</table>
      				</div>
      				<?php
      				$i= $i + 1;
      			}	
      			$_SESSION['Tableau'] = $Lib;
      			$ValidationFicheHorsForfait = true;
      			$_SESSION['ValidationFicheHorsForfait'] = $ValidationFicheHorsForfait;
      		}else{}
					// **********************************************************************************
      		?>
      		Nb Justificatifs
      		<input type="text" name="hcMontant"/>
      		<label>&nbsp;</label>
      		<input type="reset" value="Effacer"/>
      		<input type="submit" name="Valider" value="Valider" />
      		<?php
 }//Fin du else pour les frais
 ?>
</form>
</div>
</div>
<?php

}//Fin du IF du choix du visiteur

//Quand l'utilisateur appuis sur le bouton valider
if(isset($_POST["Valider"])){

	if(isset($_POST['situ'])){

    //Récupération du choix du Select pour les frai en forfait
		$Resultat_Frais_Forfait = $_POST["situ"];

    //Compte du nombre de choix qu'a fait le comptable sur les frais hors forfait
		$compteur = 0;
		$situ_horsForfait = $_POST["situ_horsForfait"];
		foreach ($situ_horsForfait as $value) {
			$compteur++;
		}
    //Récupération du nombre de frais hors forfait
		$nombre = Compte_Nombre_frais_horsForfait($idCnx, $_SESSION['id_du_Visiteur'], $_SESSION['date']);

    //Si les deux nombres ne correspondent pas, alors c'est que le comptable a oublier de valider ou de refuser un frais hors forfait
		if($compteur != $nombre["Count(id)"]){
			echo "<br> Merci de validé ou refuser tous les frais hors forfait.";
		}else{
      //Traitement des frais hors forfait
			$compteur = 0;
      //Traitement des cas hors forfait
			foreach($_POST["situ_horsForfait"] as $value)
			{
				if($value == 'R'){
					$libelle = $_SESSION['Tableau'][$compteur];
					Modifier_frais_horsForfait_Refuser($idCnx, $_SESSION['id_du_Visiteur'], $_SESSION['date'], $libelle);
				}

				$compteur += 1;
			}

      // *******************PARTIE DES DIFFERENTS AFFICHAGE EN FONCTION DU CHOIX DU COMPTABLE******************

      //On ne test pas les frais hors forfait car ils sont déjà tester plus haut.

			$Resultat_Final = Traitement_selon_choixComptable($idCnx, $Resultat_Frais_Forfait, $_SESSION['ValidationFicheHorsForfait'], $_SESSION['id_du_Visiteur'], $_SESSION['date']);

      // *****************************************************************************************************

		}

	}else{
		echo "<br>Merci de choisir de valider ou refuser les frais en forfait du visiteur.";
	}
	?>
	<?php
}
?>
</div>
</div>
<!-- Fin de la division principal -->

<?php
require($repInclude . "_pied.inc.html");
require($repInclude . "_fin.inc.php");
?>
