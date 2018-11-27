<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="style/style.css" />
	<title> Cryptage MD5 </title>
</head>
<body>

	<!-- Information -->
	<!-- Div page -->
	<div id="page">
		<header id="entete">
			<!-- Information -->
			<h1 id ="texteHeader" align="center">Cryptage des mots de passe GSB par MD5</h1>
			<img id="logo" src="images/logo.jpg">
		</header>

		<h3 align="center">Les mots de passes ont bien été crypter en MD5 :</h3>
		<?php
		$db = mysqli_connect('localhost', 'root', ''); 
		mysqli_select_db('gsb-frais',$db); 

		$requete2 = "Update Visiteur Set mdp = md5(mdp)";
		$reponse = mysqli_query($db, $requete2);

		?>

		<!-- Début du tableau -->
		<table align="center" border>
			<tr>
				<td><b>Nom</b></td>
				<td><b>Prénom</b></td>
				<td><b>Login des utilisateurs</b></td>
				<td><b>Mot de passe</b></td>
			</tr>

			<?php
			$requete3 = "Select * From Visiteur";
// Envoie de la requete
			$reponse3 = mysqli_query($db, $requete3);

			while($donnees3 = mysqli_fetch_assoc($reponse3)){

				echo '<tr><td>'.$donnees3["nom"].'</td> <td>'.$donnees3["prenom"].'</td> <td>'.$donnees3["login"].'</td> <td><strong>'.$donnees3["mdp"].'</strong></td></tr>';

			}

			?>
		</table>

		<footer id="pied">
		</footer>

	</div>
	<!-- Fin div page -->
</body>

</html>





