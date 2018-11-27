<?php

$repInclude = '.././include/';
require($repInclude . "_init.inc.php");

ob_start();

//Fonction permettant de récupérer les informations d'une fiche de frais pour le mois données
$tab = Information_Fiche_For_PDF($_SESSION['id_du_Visiteur'], $_SESSION['date']);
?>

<style type="text/css">
	table{ width: 100%; vertical-align: top; margin-left: 25px;}
</style>


<page>

	<!-- Logo de l'entreprise GSB -->
	<img src="logo.jpg">
	<!-- Titre principal de la page avec le nom du visiteur -->
	<h1 align="center">Fiche de remboursement de <?= $tab['nom'] ?></h1>
	<h3 align="center"><?= $tab['date'] ?></h3><br>

<!-- Tableau d'information des visiteurs et comptables -->
<table>
	<tr>
		<td style="width:60%;">
			<strong><?php echo $tab['nom'] . " " .  $tab['prenom']; ?></strong><br>
			<?= $tab['adresse'] ?><br>
			<?php echo $tab['ville']. " ". $tab['cp']; ?><br>
		</td>
	</tr>
</table>

<br><br><br>

<h4 align='center'>Frais en Forfait</h4>
<!-- Tableau pour les frais Forfait -->
<table border='0.5'>
	<tr>
		<td style="width:20%;">Repas (25€/u)</td>
		<td style="width:20%;">Nuitées (80€/u)</td>
		<td style="width:20%;">Etapes (110€/u)</td>
		<td style="width:20%;">Km (0.62€/u)</td>
		<td style="width:10%;"><strong>Total</strong></td>
	</tr>
	<tr>
		<td style="width:20%;"><?= $tab['REP'] ?></td>
		<td style="width:20%;"><?= $tab['NUI'] ?></td>
		<td style="width:20%;"><?= $tab['ETP'] ?></td>
		<td style="width:20%;"><?= $tab['KM'] ?></td>
		<td style="width:10%;"><strong><?= $tab['total'] . "€"; ?></strong></td>
	</tr>
</table>


<br><br><br><br><br>

<h4 align='center'>Frais hors Forfait</h4>
<!-- Tableau pour les frais hors Forfait -->
<table border='0.5'>
	<tr>
		<td style="width:20%">Date</td>
		<td style="width:50%">Libellé</td>
		<td style="width:20%"><strong>Montant</strong></td>
	</tr>
	<tr>
		<td style="width:20%"><?= $tab['dateHF'] ?></td>
		<td style="width:50%"><?= $tab['libelleHF']  ?></td>
		<td style="width:20%"><?= $tab['prixHF']  ?></td>
	</tr>


</table>

<!-- PARTIE BAS DE LA PAGE -->
<?php
// Récupération de la date pour le footer
$jour = date('j');
$mois = date('m');
$annees = date('y');
?>
	<page_footer>
		<p align="right">Fait le : <?php echo $jour ?>/<?php echo $mois ?>/<?php echo $annees ?><br>Lu et approuvé par la société GSB.</p>

	</page_footer>


</page>


<?php
$content = ob_get_clean();
require('html2pdf/html2pdf.class.php');

try{
	$pdf = new HTML2PDF('P','A4','fr');
	$pdf->pdf->SetDisplayMode('fullpage');
	$pdf->writeHTML($content);
	$pdf->Output('test.pdf');

}catch(HTML2PDF_exception $e){
	die($e);
}



?>
