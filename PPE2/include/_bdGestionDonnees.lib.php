<?php
require('conf/config.php');
/**
 * Regroupe les fonctions d'acc�s aux donn�es.
 * @package default
 * @author Arthur Martin
 * @todo Fonctions retournant plusieurs lignes sont � r��crire.
 */

/**
 * Se connecte au serveur de donn�es MySql.
 * Se connecte au serveur de donn�es MySql � partir de valeurs
 * pr�d�finies de connexion (h�te, compte utilisateur et mot de passe).
 * Retourne l'identifiant de connexion si succ�s obtenu, le bool�en false
 * si probl�me de connexion.
 * @return resource identifiant de connexion
 */
function connecterServeurBD() {
	 $idCnx = mysqli_connect(BDD_SERVER, BDD_USER, BDD_MDP, BDD_BASE);
    if (mysqli_connect_errno()) {
        $idCnx = mysqli_connect_errno();
    } elseif (mysqli_connect_error()) {
        $idCnx = mysqli_connect_error();
    }
    return $idCnx;
}

/**
 * S�lectionne (rend active) la base de donn�es.
 * S�lectionne (rend active) la BD pr�d�finie db670672695 sur la connexion
 * identifi�e par $idCnx. Retourne true si succ�s, false sinon.
 * @param resource $idCnx identifiant de connexion
 * @return boolean succ�s ou �chec de s�lection BD
 */
function activerBD($idCnx) {
	$bd = BDD_BASE;
	$query = "SET CHARACTER SET utf8";
    // Modification du jeu de caract�res de la connexion
	$res = mysqli_query($idCnx, $query);
    if (!$res) {
        return false;
    }
    return true;
}

/**
 * Ferme la connexion au serveur de donn�es.
 * Ferme la connexion au serveur de donn�es identifi�e par l'identifiant de
 * connexion $idCnx.
 * @param resource $idCnx identifiant de connexion
 * @return void
 */
function deconnecterServeurBD($idCnx) {
	mysqli_close($idCnx);
}

/**
 * Echappe les caract�res sp�ciaux d'une cha�ne.
 * Envoie la cha�ne $str �chapp�e, c�d avec les caract�res consid�r�s sp�ciaux
 * par MySql (tq la quote simple) pr�c�d�s d'un \, ce qui annule leur effet sp�cial
 * @param string $str cha�ne � �chapper
 * @return string cha�ne �chapp�e
 */
function filtrerChainePourBD($str) {
	if (!get_magic_quotes_gpc()) {
        // si la directive de configuration magic_quotes_gpc est activ�e dans php.ini,
        // toute cha�ne re�ue par get, post ou cookie est d�j� �chapp�e 
        // par cons�quent, il ne faut pas �chapper la cha�ne une seconde fois   
        $co = connecterServeurBD();
        $str = mysqli_real_escape_string($co, $str);
    }
    return $str;
}

/**
 * Fournit les informations sur un visiteur demand�.
 * Retourne les informations du visiteur d'id $unId sous la forme d'un tableau
 * associatif dont les cl�s sont les noms des colonnes(id, nom, prenom).
 * @param resource $idCnx identifiant de connexion
 * @param string $unId id de l'utilisateur
 * @return array  tableau associatif du visiteur
 */
function obtenirDetailVisiteur($idCnx, $unId) {
	$id = filtrerChainePourBD($unId);
	$requete = "SELECT id, nom, prenom FROM ". BDD_BASE .".Visiteur WHERE id='" . $id . "'";
	$idJeuRes = mysqli_query($idCnx, $requete);
    $ligne = false;
    if ($idJeuRes) {
        $ligne = mysqli_fetch_assoc($idJeuRes);
        mysqli_free_result($idJeuRes);
    }
    return $ligne;
}

/**
 * Fournit les informations d'une fiche de frais.
 * Retourne les informations de la fiche de frais du mois de $unMois (MMAAAA)
 * sous la forme d'un tableau associatif dont les cl�s sont les noms des colonnes
 * (nbJustitificatifs, idEtat, libelleEtat, dateModif, montantValide).
 * @param resource $idCnx identifiant de connexion
 * @param string $unMois mois demand� (MMAAAA)
 * @param string $unIdVisiteur id visiteur
 * @return array tableau associatif de la fiche de frais
 */
function obtenirDetailFicheFrais($idCnx, $unMois, $unIdVisiteur) {
	$unMois = filtrerChainePourBD($unMois);
	$ligne = false;
	$requete="SELECT IFNULL(nbJustificatifs,0) AS nbJustificatifs, Etat.id AS idEtat, libelle AS libelleEtat, dateModif, montantValide
	FROM ". BDD_BASE .".FicheFrais
	INNER JOIN ". BDD_BASE .".Etat ON (idEtat = Etat.id)
	WHERE idVisiteur='" . $unIdVisiteur . "'
	AND mois='" . $unMois . "'";
	$idJeuRes = mysqli_query($idCnx, $requete);
    if ($idJeuRes) {
        $ligne = mysqli_fetch_assoc($idJeuRes);
    }

    return $ligne;
}

/**
 * V�rifie si une fiche de frais existe ou non.
 * Retourne true si la fiche de frais du mois de $unMois (MMAAAA) du visiteur
 * $idVisiteur existe, false sinon.
 * @param resource $idCnx identifiant de connexion
 * @param string $unMois mois demand� (MMAAAA)
 * @param string $unIdVisiteur id visiteur
 * @return bool�en existence ou non de la fiche de frais
 */
function existeFicheFrais($idCnx, $unMois, $unIdVisiteur) {
	$unMois = filtrerChainePourBD($unMois);
	$requete = "SELECT idVisiteur FROM FicheFrais WHERE idVisiteur='" . $unIdVisiteur .
	"' AND mois='" . $unMois . "'";
	$idJeuRes = mysqli_query($idCnx, $requete);
        $ligne = false;
        if ($idJeuRes) {
            $ligne = mysqli_fetch_assoc($idJeuRes);
            mysqli_free_result($idJeuRes);
        }

        // si $ligne est un tableau, la fiche de frais existe, sinon elle n'exsite pas
        return is_array($ligne);
}

/**
 * Fournit le mois de la derni�re fiche de frais d'un visiteur.
 * Retourne le mois de la derni�re fiche de frais du visiteur d'id $unIdVisiteur.
 * @param resource $idCnx identifiant de connexion
 * @param string $unIdVisiteur id visiteur
 * @return string dernier mois sous la forme AAAAMM
 */
function obtenirDernierMoisSaisi($idCnx, $unIdVisiteur) {
	$requete = "SELECT MAX(mois) AS dernierMois FROM FicheFrais WHERE idVisiteur='" .
	$unIdVisiteur . "'";
	$idJeuRes = mysqli_query($idCnx, $requete);
        $dernierMois = false;
        if ($idJeuRes) {
            $ligne = mysqli_fetch_assoc($idJeuRes);
            $dernierMois = $ligne["dernierMois"];
            mysqli_free_result($idJeuRes);
        }
        return $dernierMois;
}

/**
 * Ajoute une nouvelle fiche de frais et les �l�ments forfaitis�s associ�s,
 * Ajoute la fiche de frais du mois de $unMois (MMAAAA) du visiteur
 * $idVisiteur, avec les �l�ments forfaitis�s associ�s dont la quantit� initiale
 * est affect�e � 0. Cl�t �ventuellement la fiche de frais pr�c�dente du visiteur.
 * @param resource $idCnx identifiant de connexion
 * @param string $unMois mois demand� (MMAAAA)
 * @param string $unIdVisiteur id visiteur
 * @return void
 */
function ajouterFicheFrais($idCnx, $unMois, $unIdVisiteur) {
	$unMois = filtrerChainePourBD($unMois);
    // modification de la derni�re fiche de frais du visiteur
	$dernierMois = obtenirDernierMoisSaisi($idCnx, $unIdVisiteur);
	$laDerniereFiche = obtenirDetailFicheFrais($idCnx, $dernierMois, $unIdVisiteur);
	if ( is_array($laDerniereFiche) && $laDerniereFiche['idEtat']=='CR'){
		modifierEtatFicheFrais($idCnx, $dernierMois, $unIdVisiteur, 'CL');
	}

    // ajout de la fiche de frais � l'�tat Cr��
	$requete = "INSERT INTO FicheFrais (idVisiteur, mois, nbJustificatifs, montantValide, idEtat, dateModif) VALUES ('"
	. $unIdVisiteur
	. "','" . $unMois . "',0,NULL, 'CR', '" . date("Y-m-d") . "')";
	mysqli_query($idCnx, $requete);

    // ajout des �l�ments forfaitis�s
	$requete = "SELECT id FROM FraisForfait";
	$idJeuRes = mysqli_query($idCnx, $requete);
	if ( $idJeuRes ) {
		$ligne = mysqli_fetch_assoc($idJeuRes);
		while ( is_array($ligne) ) {
			$idFraisForfait = $ligne["id"];
            // insertion d'une ligne frais forfait dans la base
			$requete = "INSERT INTO LigneFraisForfait (idVisiteur, mois, idFraisForfait, quantite)
			VALUES ('" . $unIdVisiteur . "','" . $unMois . "','" . $idFraisForfait . "',0)";
			mysqli_query($idCnx, $requete);
            // passage au frais forfait suivant
			$ligne = mysqli_fetch_assoc($idJeuRes);
        }
        mysqli_free_result($idJeuRes);
	}
}

/**
 * Retourne le texte de la requ�te select concernant les mois pour lesquels un
 * visiteur a une fiche de frais.
 *
 * La requ�te de s�lection fournie permettra d'obtenir les mois (AAAAMM) pour
 * lesquels le visiteur $unIdVisiteur a une fiche de frais.
 * @param string $unIdVisiteur id visiteur
 * @return string texte de la requ�te select
 */
function obtenirReqMoisFicheFrais($unIdVisiteur) {
	$req = "SELECT FicheFrais.mois AS mois FROM  FicheFrais WHERE FicheFrais.idVisiteur ='"
	. $unIdVisiteur . "' ORDER BY FicheFrais.mois desc ";
	return $req ;
}

/**
 * Retourne le texte de la requ�te select concernant les �l�ments forfaitis�s
 * d'un visiteur pour un mois donn�s.
 *
 * La requ�te de s�lection fournie permettra d'obtenir l'id, le libell� et la
 * quantit� des �l�ments forfaitis�s de la fiche de frais du visiteur
 * d'id $idVisiteur pour le mois $mois
 * @param string $unMois mois demand� (MMAAAA)
 * @param string $unIdVisiteur id visiteur
 * @return string texte de la requ�te select
 */
function obtenirReqEltsForfaitFicheFrais($unMois, $unIdVisiteur) {
	$unMois = filtrerChainePourBD($unMois);
	$requete = "SELECT idFraisForfait, libelle, quantite FROM LigneFraisForfait
	INNER JOIN FraisForfait ON FraisForfait.id = LigneFraisForfait.idFraisForfait
	WHERE idVisiteur='" . $unIdVisiteur . "' AND mois='" . $unMois . "'";
	return $requete;
}

/**
 * Retourne le texte de la requ�te select concernant les �l�ments hors forfait
 * d'un visiteur pour un mois donn�s.
 *
 * La requ�te de s�lection fournie permettra d'obtenir l'id, la date, le libell�
 * et le montant des �l�ments hors forfait de la fiche de frais du visiteur
 * d'id $idVisiteur pour le mois $mois
 * @param string $unMois mois demand� (MMAAAA)
 * @param string $unIdVisiteur id visiteur
 * @return string texte de la requ�te select
 */
function obtenirReqEltsHorsForfaitFicheFrais($unMois, $unIdVisiteur) {
	$unMois = filtrerChainePourBD($unMois);
	$requete = "select id, date, libelle, montant from LigneFraisHorsForfait
	where idVisiteur='" . $unIdVisiteur
	. "' and mois='" . $unMois . "'";
	return $requete;
}

/**
 * Supprime une ligne hors forfait.
 * Supprime dans la BD la ligne hors forfait d'id $unIdLigneHF
 * @param resource $idCnx identifiant de connexion
 * @param string $idLigneHF id de la ligne hors forfait
 * @return void
 */
function supprimerLigneHF($idCnx, $unIdLigneHF) {
	$requete = "DELETE FROM LigneFraisHorsForfait WHERE id = " . $unIdLigneHF;
	mysqli_query($idCnx, $requete);
}

/**
 * Ajoute une nouvelle ligne hors forfait.
 * Ins�re dans la BD la ligne hors forfait de libell� $unLibelleHF du montant
 * $unMontantHF ayant eu lieu � la date $uneDateHF pour la fiche de frais du mois
 * $unMois du visiteur d'id $unIdVisiteur
 * @param resource $idCnx identifiant de connexion
 * @param string $unMois mois demand� (AAMMMM)
 * @param string $unIdVisiteur id du visiteur
 * @param string $uneDateHF date du frais hors forfait
 * @param string $unLibelleHF libell� du frais hors forfait
 * @param double $unMontantHF montant du frais hors forfait
 * @return void
 */
function ajouterLigneHF($idCnx, $unMois, $unIdVisiteur, $uneDateHF, $unLibelleHF, $unMontantHF) {
	$unLibelleHF = filtrerChainePourBD($unLibelleHF);
	$uneDateHF = filtrerChainePourBD(convertirDateFrancaisVersAnglais($uneDateHF));
	$unMois = filtrerChainePourBD($unMois);
	$requete = "INSERT INTO LigneFraisHorsForFait(idVisiteur, mois, date, libelle, montant)
	VALUES ('" . $unIdVisiteur . "','" . $unMois . "','" . $uneDateHF . "','" . $unLibelleHF . "'," . $unMontantHF .")";
	mysqli_query($idCnx, $requete);
}

/**
 * Modifie les quantit�s des �l�ments forfaitis�s d'une fiche de frais.
 * Met � jour les �l�ments forfaitis�s contenus
 * dans $desEltsForfaits pour le visiteur $unIdVisiteur et
 * le mois $unMois dans la table LigneFraisForfait, apr�s avoir filtr�
 * (annul� l'effet de certains caract�res consid�r�s comme sp�ciaux par
 *  MySql) chaque donn�e
 * @param resource $idCnx identifiant de connexion
 * @param string $unMois mois demand� (MMAAAA)
 * @param string $unIdVisiteur  id visiteur
 * @param array $desEltsForfait tableau des quantit�s des �l�ments hors forfait
 * avec pour cl�s les identifiants des frais forfaitis�s
 * @return void
 */
function modifierEltsForfait($idCnx, $unMois, $unIdVisiteur, $desEltsForfait) {
	$unMois=filtrerChainePourBD($unMois);
	$unIdVisiteur=filtrerChainePourBD($unIdVisiteur);
	foreach ($desEltsForfait as $idFraisForfait => $quantite) {
		$requete = "UPDATE LigneFraisForfait SET quantite = " . $quantite
		. " WHERE idVisiteur = '" . $unIdVisiteur . "' and mois = '"
		. $unMois . "' AND idFraisForfait='" . $idFraisForfait . "'";
		mysqli_query($idCnx, $requete);
	}
}

/**
 * Contr�le les informations de connexionn d'un utilisateur.
 * V�rifie si les informations de connexion $unLogin, $unMdp sont ou non valides.
 * Retourne les informations de l'utilisateur sous forme de tableau associatif
 * dont les cl�s sont les noms des colonnes (id, nom, prenom, login, mdp)
 * si login et mot de passe existent, le bool�en false sinon.
 * @param resource $idCnx identifiant de connexion
 * @param string $unLogin login
 * @param string $unMdp mot de passe
 * @return array tableau associatif ou bool�en false
 */
function verifierInfosConnexion($idCnx, $unLogin, $unMdp) {
	$unLogin = filtrerChainePourBD($unLogin);
	$unMdp = filtrerChainePourBD($unMdp);
    // le mot de passe est crypt� dans la base avec la fonction de hachage md5
	$req = "SELECT id, nom, prenom, login, mdp FROM Visiteur WHERE login='".$unLogin."' AND mdp='" . $unMdp . "'";
	$idJeuRes = mysqli_query($idCnx, $req);
    $ligne = false;
    if ($idJeuRes) {
        $ligne = mysqli_fetch_assoc($idJeuRes);
        mysqli_free_result($idJeuRes);
    }
    return $ligne;
}

/**
* V�rifie le type de la personne qui se connecte dans la base de donn�es
*@param ressource $unLogin
*@param ressource $unMdp
*@return la valeur du type (1 ou 2)
*/

function verifierType($idCnx, $unLogin, $unMdp) {
	$unLogin = filtrerChainePourBD($unLogin);
	$unMdp = filtrerChainePourBD($unMdp);

	$req = "SELECT type FROM Visiteur WHERE login='".$unLogin."' AND mdp='" . $unMdp . "'";
	$reponse = mysqli_query($idCnx, $req);
	echo '<pre>'.var_export($reponse,true).'</pre>';
	$donnees = mysqli_fetch_assoc($reponse);

	if($donnees["type"] == '1'){
		return 1;
	}elseif($donnees["type"] == '2'){
		return 2;
	}

}


/**
 * Modifie l'�tat et la date de modification d'une fiche de frais
 * Met � jour l'�tat de la fiche de frais du visiteur $unIdVisiteur pour
 * le mois $unMois � la nouvelle valeur $unEtat et passe la date de modif �
 * la date d'aujourd'hui
 * @param resource $idCnx identifiant de connexion
 * @param string $unIdVisiteur
 * @param string $unMois mois sous la forme aaaamm
 * @return void
 */
function modifierEtatFicheFrais($idCnx, $unMois, $unIdVisiteur, $unEtat) {
	$requete = "UPDATE FicheFrais SET idEtat = '" . $unEtat .
	"', dateModif = now() WHERE idVisiteur ='" .
	$unIdVisiteur . "' AND mois = '". $unMois . "'";
	mysqli_query($idCnx, $requete);
}



function Recuperer_Information_Visiteur($idCnx, $unIdVisiteur){
	$requete = "SELECT nom, prenom, adresse, cp, ville, dateEmbauche FROM Visiteur WHERE id='$unIdVisiteur'";
	$reponse = mysqli_query($idCnx, $requete);
	$donnees = mysqli_fetch_assoc($reponse);

	return $donnees;
}




function Affichage_liste_deroulante($idCnx, $visiteur=""){
	$requete = "SELECT * FROM Visiteur WHERE type='1'";
	$reponse = mysqli_query($idCnx, $requete);
	while($donnees = mysqli_fetch_assoc($reponse)){
		if ($visiteur == $donnees['id']){
			echo "<option value =" . $donnees['id'] . " selected >" . $donnees['nom']  . "</option>";
		}else{
			echo "<option value =" . $donnees['id'] . " >" . $donnees['nom']  . "</option>";
		}
	}
}


function Cloture_ficheVisiteur($idCnx, $dateCloture){
	$requete = "UPDATE FicheFrais SET idEtat = 'CL' WHERE mois <= '$dateCloture' AND idEtat = 'CR' ";
	$reponse = mysqli_query($idCnx, $requete);
}


/**
*R�cup�re les frais en forfait d'un visiteur en fonction du mois courant et du type.
*@param String $unIdVisiteur
*@param int $date
*@param String $type
*@return tableau associatif
*/
function Recup_frais_forfait($idCnx, $unIdVisiteur, $date, $type){
	$requete = "SELECT * FROM LigneFraisForfait, FicheFrais, Visiteur
	WHERE Visiteur.id = FicheFrais.idVisiteur
	AND FicheFrais.idVisiteur = LigneFraisForfait.idVisiteur
	AND FicheFrais.idVisiteur = '$unIdVisiteur'
	AND LigneFraisForfait.mois = '$date'
	AND LigneFraisForfait.idFraisForfait = '$type'
	AND (FicheFrais.idEtat = 'CR' OR FicheFrais.idEtat = 'CL') ";
	$reponse = mysqli_query($idCnx, $requete);
	$donnees = mysqli_fetch_assoc($reponse);

	return $donnees;
}

function Recup_frais_forfaitValide($idCnx, $unIdVisiteur, $date, $type){
	$requete = "SELECT * FROM LigneFraisForfait, FicheFrais, Visiteur
	WHERE Visiteur.id = FicheFrais.idVisiteur
	AND FicheFrais.idVisiteur = LigneFraisForfait.idVisiteur
	AND FicheFrais.idVisiteur = '$unIdVisiteur'
	AND LigneFraisForfait.mois = '$date'
	AND LigneFraisForfait.idFraisForfait = '$type'
	AND FicheFrais.idEtat = 'VA' ";
	$reponse = mysqli_query($idCnx, $requete);
	$donnees = mysqli_fetch_assoc($reponse);

	return $donnees;
}

function Recup_frais_horsForfait($idCnx, $unIdVisiteur, $date){
	$requete = "SELECT * FROM LigneFraisHorsForfait WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date' ";
	$reponse = mysqli_query($idCnx, $requete);
    //R�cup�ration du r�sultat des fiches hors forfait
	$donnees = mysqli_fetch_assoc($reponse);

	return $donnees;
}

function Existe_Fiche_Frais_NonValide($idCnx, $unIdVisiteur, $date){
	$requete = "SELECT idVisiteur FROM FicheFrais WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date' AND (idEtat = 'CR' OR idEtat = 'CL')";
	$reponse = mysqli_query($idCnx, $requete);
	$donnees = mysqli_fetch_assoc($reponse);

	if($donnees == ""){
		return false;
	}else{
		return true;
	}
}

function Existe_Fiche_Frais_Valide($idCnx, $unIdVisiteur, $date){
	$requete = "SELECT idVisiteur FROM FicheFrais WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date' AND idEtat = 'VA'";
	$reponse = mysqli_query($idCnx, $requete);
	$donnees = mysqli_fetch_assoc($reponse);

	if($donnees == ""){
		return false;
	}else{
		return true;
	}
}



function Etat_Fiche_Frais($idCnx, $unIdVisiteur, $date){
	$requete = "SELECT idEtat FROM FicheFrais WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date'";
	$reponse = mysqli_query($idCnx, $requete);
	$donnees = mysqli_fetch_assoc($reponse);

	return $donnees['idEtat'];
}



function Existe_frais_horsForfait($idCnx, $unIdVisiteur, $date){
	$requete = "SELECT * FROM LigneFraisHorsForfait WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date' ";
	$reponse = mysqli_query($idCnx, $requete);
	$donnees = mysqli_fetch_assoc($reponse);

	return $donnees;
}

function Modifier_frais_horsForfait_Refuser($idCnx, $unIdVisiteur, $date, $libelle){

  //Modifier le libelle pour ne pas prendre les caractère spéciaux
	$libelle = filtrerChainePourBD($libelle);


  //Modification du prix du frais hors forfait
	$requete = "UPDATE LigneFraisHorsForfait SET montant = 0 WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date' AND libelle = '$libelle'";
	$reponse = mysqli_query($idCnx, $requete);

  //Modification du libelle du frais hors forfait
	$requete = "UPDATE LigneFraisHorsForfait SET libelle = CONCAT(libelle, ' REFUSER') where idVisiteur = '$unIdVisiteur' AND mois = '$date' AND libelle = '$libelle'";
	$reponse = mysqli_query($idCnx, $requete);

}

function Compte_Nombre_frais_horsForfait($idCnx, $unIdVisiteur, $date){
	$requete = "SELECT Count(id) FROM LigneFraisHorsForfait WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date'";
	$reponse = mysqli_query($idCnx, $requete);
	$donnees = mysqli_fetch_assoc($reponse);

	return $donnees;
}


function Traitement_selon_choixComptable($idCnx, $Resultat_Frais_Forfait, $ValidationFicheHorsForfait, $unIdVisiteur, $date){

    //Si les frais en forfait sont valid� et qu'il y avais des hors forfait alors on valide
	if($Resultat_Frais_Forfait == "V" && $ValidationFicheHorsForfait == true){
		$requete = "UPDATE FicheFrais SET idEtat = 'VA' WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date' ";
		$reponse = mysqli_query($idCnx, $requete);

		echo "<br>La fiche du visiteur a ete valide en entier.";
	}

    //Si les frais en forfait son valid� et qu'il n'y avais pas de hors forfait alors on valide
	if($Resultat_Frais_Forfait == "V" && $ValidationFicheHorsForfait == false){
		$requete = "UPDATE FicheFrais SET idEtat = 'VA' WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date' ";
		$reponse = mysqli_query($idCnx, $requete);

		echo "<br>La fiche du visiteur a ete valide.";
	}

    //Si les frais en forfait son refus� et qu'il n'y avais pas de hors forfait alors on refuse
	if($Resultat_Frais_Forfait == "R" && $ValidationFicheHorsForfait == false){
		$requeteEtape = "UPDATE LigneFraisForfait SET quantite = 0 WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date' AND idFraisForfait = 'ETP'";
		$reponse = mysqli_query($idCnx, $$requeteEtape);

		$requeteKm = "UPDATE LigneFraisForfait SET quantite = 0 WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date' AND idFraisForfait = 'KM'";
		$reponse = mysqli_query($idCnx, $requeteKm);

		$requeteNuitee = "UPDATE LigneFraisForfait SET quantite = 0 WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date' AND idFraisForfait = 'NUI'";
		$reponse = mysqli_query($idCnx, $requeteNuitee);

		$requeteRepas = "UPDATE LigneFraisForfait SET quantite = 0 WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date' AND idFraisForfait = 'REP'";
		$reponse = mysqli_query($idCnx, $requeteRepas);

		echo "<br>Vous avez refuser les frais en forfait et il n'y avais pas de frais hors forfait, la fiche n'est donc pas valid� pour ce visiteur et les quantités passé à 0.";
	}

    //Si les frais en forfait son refus� et qu'il y avais des hors forfait alors on valide en mettant les frais � 0
	if($Resultat_Frais_Forfait == "R" && $ValidationFicheHorsForfait == true){
        //Changement des frais en forfait � O car ils ont �t� refus�
		$requeteEtape = "UPDATE LigneFraisForfait SET quantite = 0 WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date' AND idFraisForfait = 'ETP'";
		$reponse = mysqli_query($idCnx, $requeteEtape);

		$requeteKm = "UPDATE LigneFraisForfait SET quantite = 0 WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date' AND idFraisForfait = 'KM'";
		$reponse = mysqli_query($idCnx, $requeteKm);

		$requeteNuitee = "UPDATE LigneFraisForfait SET quantite = 0 WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date' AND idFraisForfait = 'NUI'";
		$reponse = mysqli_query($idCnx, $requeteNuitee);

		$requeteRepas = "UPDATE LigneFraisForfait SET quantite = 0 WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date' AND idFraisForfait = 'REP'";
		$reponse = mysqli_query($idCnx, $requeteRepas);

        //Validation de la fiche
		$requete = "UPDATE FicheFrais SET idEtat = 'VA' WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date' ";
		$reponse = mysqli_query($idCnx, $requete);


		echo "<br>Vous avez refuser les frais en forfait, ils sont donc pass� � 0. La fiche a �t� valid� pour les frais hors forfait";
	}


}

function Remboursement_fiche_frais($idCnx, $unIdVisiteur, $date){
	$requete = "UPDATE FicheFrais SET idEtat = 'RB' WHERE idVisiteur = '$unIdVisiteur' AND mois = '$date' ";
	$reponse = mysqli_query($idCnx, $requete);

	echo "La fiche du visiteur est rembourse.";
}

function Transformation_Date_String($uneDate){
	$date_affichage = "";

	switch ($uneDate) {
		case '201801':
		$date_affichage = "Janvier 2018";
		break;

		case '201802':
		$date_affichage = "Février 2018";
		break;

		case '201803':
		$date_affichage = "Mars 2018";
		break;

		case '201804':
		$date_affichage = "Avril 2018";
		break;

		case '201805':
		$date_affichage = "Mai 2018";
		break;

		case '201806':
		$date_affichage = "Juin 2018";
		break;

		case '201807':
		$date_affichage = "Juillet 2018";
		break;

		case '201808':
		$date_affichage = "Aout 2018";
		break;

		case '201809':
		$date_affichage = "Septembre 2018";
		break;

		case '201810':
		$date_affichage = "Octobre 2018";
		break;

		case '201811':
		$date_affichage = "Novembre 2018";
		break;

		case '201812':
		$date_affichage = "Décembre 2018";
		break;


	}


	return $date_affichage;
}

function choix_mois($mois_choisi =""){

	$year = date('Y');
	$mois_en_cours = date('m');


	if ($mois_en_cours != '10'){
      $mois_en_cours = str_replace("0", "" , $mois_en_cours); // Mois en cours sans le 0 du début
  }

  for ($i=1; $i <= $mois_en_cours ; $i++) {

  	if($i<10){
  		$date = Transformation_Date_String($year.'0'.$i);
  		$valeur = '0'.$i;
  	}else{
  		$date = Transformation_Date_String($year.$i);
  		$valeur = $i;
  	}

  	if($mois_choisi == $i){
  		echo "<option value='".$valeur."' selected>".$date."</option>";
  	}else{
  		echo "<option value='".$valeur."'>".$date."</option>";
  	}

  }


}


/***
*   Fonction permettant de récupérer les différentes informations d'une fiche de frais pour un mois données et 
    un id donnée
*/

    function Information_Fiche_For_PDF($idCnx, $id_visiteur, $date){

    	$tab = array();

    //Requete pour récupérer les informations du visiteur
    	$requete = "SELECT nom, prenom, adresse, cp, ville FROM Visiteur WHERE id = '$id_visiteur'";
    	$reponse = mysqli_query($idCnx, $requete);
    	$donnees = mysqli_fetch_assoc($reponse);

    	$requete2 = "SELECT quantite FROM LigneFraisForfait WHERE idFraisForfait = 'ETP' AND idVisiteur = '$id_visiteur' AND mois = '$date'";
    	$reponse2 = mysqli_query($idCnx, $requete2);
    	$donnees2 = mysqli_fetch_assoc($reponse2);

    	$requete3 = "SELECT quantite FROM LigneFraisForfait WHERE idFraisForfait = 'REP' AND idVisiteur = '$id_visiteur' AND mois = '$date'";
    	$reponse3 = mysqli_query($idCnx, $requete3);
    	$donnees3 = mysqli_fetch_assoc($reponse3);

    	$requete4 = "SELECT quantite FROM LigneFraisForfait WHERE idFraisForfait = 'NUI' AND idVisiteur = '$id_visiteur' AND mois = '$date'";
    	$reponse4 = mysqli_query($idCnx, $requete4);
    	$donnees4 = mysqli_fetch_assoc($reponse4);

    	$requete5 = "SELECT quantite FROM LigneFraisForfait WHERE idFraisForfait = 'KM' AND idVisiteur = '$id_visiteur' AND mois = '$date'";
    	$reponse5 = mysqli_query($idCnx, $requete5);
    	$donnees5 = mysqli_fetch_assoc($reponse5);

    //Calcul du total des frais en Forfait
    	$total = $donnees2['quantite']*110 + $donnees3['quantite']*25 + $donnees4['quantite']*80 + $donnees5['quantite']*0.62;


    	$requete6 = "SELECT libelle, date, montant FROM LigneFraisHorsForfait WHERE idVisiteur = '$id_visiteur' AND mois = '$date'";
    	$reponse6 = mysqli_query($idCnx, $requete6);

    	$libelle_HF = "";
    	$date_HF = "";
    	$prix_HF = "";

    	while ($donnees6 = mysqli_fetch_assoc($reponse6)) {

    		$libelle_HF = "<i> -".$donnees6["libelle"]."</i>" ."<br>". $libelle_HF;
    		$date_HF = $donnees6['date'] . "<br>" . $date_HF;
    		$prix_HF = "<strong>".$donnees6["montant"]."</strong>" ."<br>".$prix_HF;

    	}

    	$date_string = Transformation_Date_String($date);

    	$tab['nom']    = $donnees['nom'];
    	$tab['prenom'] = $donnees['prenom'];
    	$tab['adresse'] = $donnees['adresse'];
    	$tab['cp'] = $donnees['cp'];
    	$tab['ville'] = $donnees['ville'];
    	$tab['ETP'] = $donnees2['quantite'];
    	$tab['REP'] = $donnees3['quantite'];
    	$tab['NUI'] = $donnees4['quantite'];
    	$tab['KM'] = $donnees5['quantite'];
    	$tab['total'] = $total;
    	$tab['date'] = $date_string;
    	$tab['libelleHF'] = $libelle_HF;
    	$tab['dateHF'] = $date_HF;
    	$tab['prixHF'] = $prix_HF;

    	return $tab;

    }




    ?>
