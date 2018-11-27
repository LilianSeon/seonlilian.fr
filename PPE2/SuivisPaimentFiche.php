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
if ( !estVisiteurConnecte() ) {
	header("Location:cSeConnecter.php");
}
require($repInclude . "_entete.inc.html");
require($repInclude . "_sommaireC.inc.php");

$Choix_Visiteur = lireDonneePost('lstVisiteur');
$Choix_Date = lireDonneePost('mois_choix');

?>
<div class="col-lg-9">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h1> Remboursement des fiches des visiteurs </h1>
		</div>
		<?php
//****************Cloture des fiches de tous les visiteurs en fonction de la date********************


// Si le jour est supérieur au 10ème jour du mois
		if(date('d') > 8){
  // Récupération de la date du mois précédent dans la variable $date_de_cloture
			$m = date('m',strtotime('2016/11/11')) - 1;
			if ($m < '10'){
    $date_de_Cloture =  date("Y") . "0" . $m; // On rajoute un 0 car le 0 s'enleve automatiquement quand on enleve 1 à $m.
}else{
    $date_de_Cloture = date("Y").$m; // Si le mois est supérieur à 10 nous ne rajoutons pas de zéro.
}

  //Fonction permettant de cloturé les fiches en cours de création
  //Cloture_ficheVisiteur($date_de_Cloture);

}

//*****************************************************************************************
?>
<div class="panel-body">
	<!-- Formulaire du choix du visiteur -->
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
  // Récupération de l'ID du visiteur qu'à choisi l'utilisateur
	$choixVisiteur = $_POST["lstVisiteur"];
	$_SESSION['id_du_Visiteur'] = $choixVisiteur;
  $date = date('Y') . $_POST['mois_choix']; //De la forme 201603 par exemple
  $_SESSION['date'] = $date; //Pour l'utiliser en dehors du formulaire

  $date_affichage = Transformation_Date_String($date);
  ?>
  <div class="panel panel-default">
  	<div class="panel-heading">
  		<h2>Fiche de frais du mois de <?= $date_affichage ?></h2>
  	</div>
  	<div class="panel-body">
  		<form method="post" action="">
  			<?php
  			//Vérification de l'existance d'une fiche qui est validé
  			$existe_Fiche_Frais = Existe_Fiche_Frais_Valide($idCnx, $_SESSION['id_du_Visiteur'], $date);
  			if($existe_Fiche_Frais == false){
    			//La fiche de frais n'est pas 'VA', On recherche donc si elle est créer ou rembourser pour un mois données
  				$Etat = Etat_Fiche_Frais($idCnx, $_SESSION['id_du_Visiteur'], $date);
  				if($Etat == "CR"){
  					echo "La fiche de frais est en cours de création côté visiteur.";
  				}elseif ($Etat == "CL") {
  					echo "La fiche de frais est cloturé et en attente de validation.";
  				}elseif ($Etat == "RB") {
     				 //La fiche est déjà remboursée, on affiche un message dans ce cas.
  					echo "La fiche de frais à déjà été remboursée.";
  				}else{
  					echo "Aucune fiche est enregistré pour ce Visiteur";
  				}
  			}else{
				// ---------PARTIE REQUETE POUR LES FRAIS EN FORFAIT----------------
  				//Récupération des repas
  				$donneesRepas = Recup_frais_forfaitValide($idCnx, $_SESSION['id_du_Visiteur'], $date, "REP");
  				//Récupération des nuitée
  				$donneesNuitee = Recup_frais_forfaitValide($idCnx, $_SESSION['id_du_Visiteur'], $date, "NUI");
  				//Récupération des Etapes
  				$donneesEtape = Recup_frais_forfaitValide($idCnx, $_SESSION['id_du_Visiteur'], $date, "ETP");
  				//Récupération des kilomètres
  				$donneesKm = Recup_frais_forfaitValide($idCnx, $_SESSION['id_du_Visiteur'], $date, "KM");
  				?>
  				<h3>Frais au forfait </h3>
  				<div class="table-responsive">
  					<table class='table table-striped table-bordered'>
  						<tr>
  							<th>Repas midi</th>
  							<th>Nuitée </th>
  							<th>Etape</th>
  							<th>Km </th>
  						</tr>

  						<tr>
  							<td><input class="form-control" readonly="readonly" type="text" name="repas" value="<?php echo $donneesRepas['quantite'] ?>"/></td>
  							<td><input class="form-control" readonly="readonly" type="text" name="nuitee" value = "<?php echo $donneesNuitee['quantite'] ?>"/></td>
  							<td><input class="form-control" readonly="readonly" type="text" name="etape" value = "<?php echo $donneesEtape['quantite'] ?>"/></td>
  							<td><input class="form-control" readonly="readonly" type="text" name="km" value = "<?php echo $donneesKm['quantite'] ?>"/></td>

  						</tr>
  					</table>
  				</div>
  				<p><b><u>Informations pour les frais en forfait</u></b></p>

  				<?php
// Pour les repas du visiteur séléctionné
  				$tauxRepas = 25;
  				$totalRepas = $donneesRepas["quantite"] * $tauxRepas;
  				echo 'Le visiteur à prit <b>' . $donneesRepas["quantite"] .'</b> repas, l\'entreprise lui doit : <b>'.$totalRepas.'€</b> à rembouser. ';
  				echo '</br>';

// Pour les nuitées du visiteur séléctionné
  				$tauxNuitée = 80;
  				$totalNuitée = $donneesNuitee["quantite"] * $tauxNuitée;
  				echo 'Le visiteur à prit <b>' . $donneesNuitee["quantite"] .'</b> nuitée, l\'entreprise lui doit : <b>'.$totalNuitée.'€</b> à rembouser. ';
  				echo '</br>';

// Pour les km du visiteur séléctionné
  				$tauxKm = 0.62;
  				$totalKm = $donneesKm["quantite"] * $tauxKm;
  				echo 'Le visiteur à roulé <b>' . $donneesKm["quantite"] .'</b> km, l\'entreprise lui doit : <b>'.$totalKm.'€</b> à rembouser. ';
  				echo '</br>';

// Pour les Etapes du visiteur séléctionné
  				$tauxEtapes = 110;
  				$totalEtapes = $donneesEtape["quantite"] * $tauxEtapes;
  				echo 'Le visiteur à parcouru <b>' . $donneesEtape["quantite"] .'</b> étapes, l\'entreprise lui doit : <b>'.$totalEtapes.'€</b> à rembouser. ';
  				echo '</br>';


	//Information final
  				echo "<br/>";
  				$Total = $totalRepas + $totalNuitée + $totalKm + $totalEtapes;
  				echo 'L entreprise remboursera <b>'.$Total.'€</b> pour les frais en forfait.';


	// ********************PARTIE POUR LES REQUETES HORS FORFAIT DES VISITEURS ET AFFICHAGE********************
  	//Vérification de l'existance de hors forfait
  				$existe_frais_horsForfait = Existe_frais_horsForfait($idCnx, $_SESSION['id_du_Visiteur'] , $date);

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
  							</tr>
  							<?php 
  							$libellé_hors_forfait = "";
  							$total_prix = "";
      	// Tant qu'il y a des lignes à affiché
  							while($donneesHF = mysqli_fetch_assoc($reponseHF)){
       	//$Lib[$i] = $donneesHF["libelle"];
  								?>
  								<tr>
  									<td><input class="form-control" readonly="readonly" type="text"  name="hfDate1" value ="<?php echo $donneesHF['date'] ?>"/></td>
  									<td><input class="form-control" readonly="readonly"  type="text"  name="hfLib1" value ="<?php echo $donneesHF["libelle"] ?>"/></td> 
  									<td><input class="form-control" readonly="readonly" type="text"  name="hfMont1" value ="<?php echo $donneesHF['montant'] ?>"/></td>
  								</tr>
  								<?php
  							}
  							$ValidationFicheHorsForfait = true;
  							$_SESSION['ValidationFicheHorsForfait'] = $ValidationFicheHorsForfait;
  						}else{

  						}
		// *********************************************************************************
  						?>
  					</table>
  				</div>
  				<a href="PDF/CreationPDF.php" target="_blank">Résumé du remboursement en PDF</a><br><br>
  				<input type="submit" name="Rembourser" value="Rembourser la fiche de frais" />
  			</form>
  			<?php
 }//Fin du else pour les frais
 ?>
</div>
</div>
<?php
}//Fin du IF

if(isset($_POST["Rembourser"])){
    //Modification de la fiche de frais dans la base de données
	$Resultat_Final = Remboursement_fiche_frais($idCnx, $_SESSION['id_du_Visiteur'], $_SESSION['date']);
}

?>
</div>
</div>
<!-- Fin de la division principal -->

<?php
require($repInclude . "_pied.inc.html");
require($repInclude . "_fin.inc.php");
?>
