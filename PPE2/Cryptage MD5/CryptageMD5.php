<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="style/style.css" />
	<title> Cryptage MD5 </title>
</head>
<body>

	<!-- Div page -->
	<div id="page">
		<header id="entete">
			<!-- Information -->
			<h1 id ="texteHeader" align="center">Cryptage des mots de passe GSB par MD5</h1>
			<img id="logo" src="images/logo.jpg">
		</header>

		<h3 align="center">Voici les mots de passe qui se trouve dans la base de données :</h3>

		<!-- Début du tableau -->
		<table align="center" border>
			<tr>
				<td><b>Nom</b></td>
				<td><b>Prénom</b></td>
				<td><b>Login des utilisateurs</b></td>
				<td><b>Mot de passe</b></td>
			</tr>

			<?php
			$db = mysql_connect('localhost', 'root', ''); 
			mysql_select_db('gsb_frais',$db); 

// Récupération de tous les mots de passes de la table Visiteur
			$requete = "Select * From Visiteur";
// Envoie de la requete
			$reponse = mysql_query($requete);

			while($donnees = mysql_fetch_assoc($reponse)){

				echo '<tr><td>'.$donnees["nom"].'</td> <td>'.$donnees["prenom"].'</td> <td>'.$donnees["login"].'</td> <td><b>'.$donnees["mdp"].'</b></td></tr>';

			}

			?>

		</table>
		<br>
		<!-- Bouton avec du JavaScript pour ouvrir le traitementMD5.php -->
		<input type="submit" value="Cryptage des mots de passe en md5" onclick="if(confirm('Attention, le cryptage MD5 est irréversible.'))
		{location.href='traitementMD5.php';} ">

		<footer id="pied">
		</footer>
	</div>
	<!-- Fin div page -->
</body>

</html>