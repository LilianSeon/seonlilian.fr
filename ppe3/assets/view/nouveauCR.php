<!DOCTYPE HTML>
<?php
//require '../phpScript/ScriptBDD.php';
require '../phpClass/ClassMedicaments.php';
?>
<html>
<head>
	<title>GSB - Comptes-Rendus</title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
	<link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection"/>
	<link type="text/css" rel="stylesheet" href="../css/main.css" media="screen,projection"/>
	<link type="text/css" rel="stylesheet" href="../css/font-awesome.min.css" media="screen,projection"/>
</head>

<body>
<?php include '../inc/sideMenu.inc.php'; ?>
<main>
	<form method="post" action="../phpScript/ScriptCreerRapport.php">
		<div class="row">
			<div class="col l10  offset-l1">
				<div class="col m11">
					<h3 class="cyan-text darken-1">Rapport de visite</h3>
				</div>

				<div class="col s12 m5 l4">
					<label>Sélectionner la date de la visite <span class="red-text">*</span></label>
					<input required name="rapportDate" type="date" class="datepicker">
				</div>
				<div class="input-field col s11">
					<a class="waves-effect waves-light btn btn-large" id="praticienTri" href="#"><i
								class="material-icons left fa fa-user-md"></i>Praticien</a>
					<input name="rapportIsRemplace" type="checkbox" id="remplace"/>
					<label for="remplace">Remplacé</label>


					<!-- #################################################################################   -->

					<!-- Praticien INFO  -->
					<div class="row">
						<div class="col l9">
							<ul class="collection with-header" id="praInfo">

							</ul>
						</div>
					</div>
					<!-- Praticien REMPLAÇANT  -->
					<div class="row">
						<div class="col l9">
							<ul class="collection with-header" id="remplacant" style="display: none;">
								<li class="collection-header"><h4>Remplaçant :</h4></li>
								<li class="collection-item">
									<input name="remplacantNom" placeholder="Nom *" type="text">
								</li>
								<li class="collection-item">
									<input name="remplacantPrenom" placeholder="Prénom *" type="text">
								</li>
								<li class="collection-item">
									<input name="remplacantAdresse" placeholder="Adresse *" type="text">
								</li>
						 		<li class="collection-item">
									<input name="remplacantVille" placeholder="Ville *" type="text">
								</li>
								<li class="collection-item">
									<input name="remplacantCP" placeholder="Code postal *" type="number" maxlength="5">
								</li>
								<li class="collection-item">
									<input name="remplacantCoef" placeholder="Coéficien de notoriété *" type="text">
								</li>
								<li class="collection-item" style="padding-bottom: 18em;">
									<select name="remplacantTypePra" size="5">
										<option value="MH">Médecin hospitalier</option>
										<option value="MV">Médecin de ville</option>
										<option value="PH">Pharmacien hospitalier</option>
										<option value="PO">Pharmacien officine</option>
										<option value="PS">Personnel de santé</option>
									</select>
								</li>
							</ul>
						</div>
					</div>


					<!-- #################################################################################   -->


					<div class="row">
						<div class="input-field col s7 l4">
							<select name="rapportMotif">
								<option value="1">Périodicité</option>
								<option value="2">Actualisation</option>
								<option value="3">Relance</option>
								<option value="4">Solicitation Praticien</option>
								<option value="5">Autres</option>
							</select>
							<label>Motif de la visite <span class="red-text">*</span></label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s10">
							<textarea name="rapportBilan" id="textarea1" class="materialize-textarea"></textarea>
							<label for="textarea1">Bilan</label>
						</div>
					</div>
					<div class="row">
						<div class="col s10">
							<h5 class="col s10 cyan-text darken-1">Eléments présentés</h5>

						</div>
					</div>


					<!-- #################### ÉLÉMENT PRÉSENTÉS  ####################################################   -->


					<div id="listElement">
						<input type="hidden" id="compteElem" value="0" name="compteElem"/>
						<div class="row element">
							<div class="input-field col m4 listMedicElem">
								<select class="selectElem" name="selectElem0">
									<option value="" disabled selected>Produits</option>
                                    <?php
                                    foreach (Medicaments::getAllDepotAndName() as $value):
                                        ?>
										<option value="<?php echo $value['MED_DEPOTLEGAL']; ?>">
                                            <?php echo $value['MED_DEPOTLEGAL'] . ' : ' . $value['MED_NOMCOMMERCIAL']; ?>
										</option>
                                        <?php
                                    endforeach;
                                    ?>
								</select>
								<label>Sélectionner un produit</label>
							</div>
							<div class="col m4">
								<input type="checkbox" id="documentation0" name="documentation0"/>
								<label for="documentation0">Documentation offerte</label>
							</div>
							<div class="col m4">
								<a id="addPresente"
								   class="btn-floating btn-large waves-effect waves-light btn tooltipped blue accent-1"
								   data-position="left" data-delay="50" data-tooltip="Ajoute un nouvel élément">
									<i class="material-icons">add</i>
								</a>
							</div>
						</div>
					</div>


					<!-- #############ÉCHANTILLONS OFFERTS ############################################   -->
					<div class="s12">
						<hr>
					</div>
					<div class="row">
						<div class="col s10">
							<h5 class="col s10 cyan-text darken-1">Échantillons offerts</h5>
						</div>
					</div>
					<div id="listEchant">
						<input type="hidden" value="0" id="compteEchant" name="compteEchant"/>
						<div class="row echant">
							<div class="input-field col m4 listMedicEchant">
								<select class="selectEchant" name="selectEchant0">
									<option value="" disabled selected>Produits</option>
                                    <?php
                                    foreach (Medicaments::getAllDepotAndName() as $value):
                                        ?>
										<option value="<?php echo $value['MED_DEPOTLEGAL']; ?>">
                                            <?php echo $value['MED_DEPOTLEGAL'] . ' : ' . $value['MED_NOMCOMMERCIAL']; ?>
										</option>
                                        <?php
                                    endforeach;
                                    ?>
								</select>
								<label>Sélectionner un produit</label>
							</div>
							<div class="col m2">
								<input type="checkbox" id="saisieDef0" name="saisieDef0"/>
								<label for="saisieDef0">Saisie définitive</label>
							</div>
							<div class="col m2">
								<input class="offqte" type="number" placeholder="Quantité" name="offQte0" />
							</div>
							<div class="col m3">
								<a id="addEchant"
								   class="btn-floating btn-large waves-effect waves-light btn tooltipped blue accent-1"
								   data-position="left" data-delay="50" data-tooltip="Ajoute un nouvel échantillon">
									<i class="material-icons">add</i>
								</a>
							</div>
						</div>
					</div>

					<div class="row">
						<input class="btn waves-effect waves-light" type="submit"/>
						<button class="btn waves-effect waves-light" type="reset">Effacer
							<i class="fa fa-close"></i>
						</button>
					</div>
                    <?php
                    $_GET['e'] = 0;
                    if (isset($_GET['e']))
                    {
                        switch ($_GET['e'])
                        {
                        case '0':
                            ?>
							<script>alert('Rapport bien enregistré. ');</script>
                        <?php
                        break;
                        case '1':
                        ?>
							<script>alert('Attention à bien remplir les champs avec * ');</script>
                            <?php
                            break;
                            case '2':
                            ?>
							<script>alert('Erreur lors de l\'enregistrement, recommencez');</script>
                            <?php
                        }
                    }
                    ?>
				</div>
			</div>
	</form>

</main>
<div id="listPraticien" class="modal bottom-sheet">
	<div class="modal-content">
		<input id="recherche" placeholder="Rechercher un practiciens"/>
        <?php
        require '../inc/getAllPraticien.inc.php';
        ?>
	</div>
</div>
<script src="../js/jquery.min.js"></script>
<script src="../js/materialize.min.js"></script>
<script src="../js/main.js"></script>
<script src="../js/recherche.js"></script>
<script>
    $('#praticienTri').on('click', function (e)
    {
        e.preventDefault();
        $('#listPraticien').modal().modal('open');
    });


    // copier l'html du modal avec la liste des praticiens dans la page
    $('.praSelectable').on('click', function ()
    {
        let praInfo = $(this).html();
        $('#praInfo').html(praInfo);
    });
    // afficher le formulaire pour ajouter un praticien si le visité est remplacé
    $('#remplace').on('click', function ()
    {
        if ($(this).is(':checked'))
        {
            $('#remplacant').fadeIn();
        } else
        {
            $('#remplacant').fadeOut();
        }
    });
    ////////////////////////////////////
    /////// elements présentés
    //////////////////////////////
    let listProduitElem = $('.listMedicElem')[0].outerHTML;
    let listProduitEchant = $('.listMedicEchant')[0].outerHTML;
    $('#addPresente').on('click', function ()
    {
        $('#listElement').append('<div class="row element">' + listProduitElem + '<div class="col m4">' +
            '<input type="checkbox" class="documentation"/><label class="docuFor">Documentation offerte</label>' +
            '</div><div class="col m4"><a class="btn-floating btn-large removeElem ' +
            'waves-effect waves-light btn tooltipped blue accent-1" data-position="left" data-delay="50" data-tooltip="Retire un élément">' +
            '<i class="fa fa-close"></i></a></div></div>');
        $('select').material_select();
        let i = 0;
        $('.element').each(function ()
        {
            $('#compteElem').val(i);
            //checkbox
            $(this).find('.documentation').attr("name", "documentation" + i).attr('id', 'documentation' + i);
            $(this).find('.docuFor').attr("for", "documentation" + i);
            //select
            $(this).find('.selectElem').attr('name', 'selectElem' + i);
            i++;
            if (i >= 10)
            {
                $('#addPresente').hide();
            }
        });
    });
    $(document).on('click', '.removeElem', function ()
    {
        let i = 0;
        $('.element').each(function ()
        {
            $('#compteElem').val(i);
            //checkbox
            $(this).find('.documentation').attr("name", "documentation" + i).attr('id', 'documentation' + i);
            $(this).find('.docuFor').attr("for", "documentation" + i);
            //select
            $(this).find('.selectElem').attr('name', 'selectElem' + i);
            i++;
            if (i < 10)
            {
                $('#addPresente').show();
            }
        });
        $(this).parent().parent().remove();
    });
    ////////////////////////////////////
    /////// echantillons
    //////////////////////////////
    $('#addEchant').on('click', function ()
    {
        $('#listEchant').append('<div class="row echant">' + listProduitEchant + '<div class="col m2">' +
            '<input type="checkbox" class="saisieDef"/><label class="saisieFor">Saisie définitive</label>' +
            '</div><div class="col m2">'+
            '<input class="offqte" required type="number" placeholder="Quantité" name="offQte0" /></div>'+
			'<div class="col m3"><a class="btn-floating btn-large removeEchant ' +
            'waves-effect waves-light btn tooltipped blue accent-1" data-position="left" data-delay="50" data-tooltip="Retire un élément">' +
            '<i class="fa fa-close"></i></a></div></div>');
        $('select').material_select();
        let i = 0;
        $('.echant').each(function ()
        {
            $('#compteEchant').val(i);
            //checkbox
            $(this).find('.saisieDef').attr("name", "saisieDef" + i).attr('id', 'saisieDef' + i);
            $(this).find('.saisieFor').attr("for", "saisieDef" + i);
            //select
            $(this).find('.selectEchant').attr('name', 'selectEchant' + i);
            // off qte
            $(this).find('.offqte').attr('name', 'offQte' + i);
            i++;
            if (i >= 10)
            {
                $('#addEchant').hide();
            }
        });
    });
    $(document).on('click', '.removeEchant', function ()
    {
        let i = 0;
        $('.echant').each(function ()
        {
            $('#compteEchant').val(i);
            //checkbox
            $(this).find('.saisieDef').attr("name", "saisieDef" + i).attr('id', 'saisieDef' + i);
            $(this).find('.saisieFor').attr("for", "saisieDef" + i);
            //select
            $(this).find('.selectEchant').attr('name', 'selectEchant' + i);
            // off qte
            $(this).find('.offqte').attr('name', 'offQte' + i);
            i++;
            if (i < 10)
            {
                $('#addEchant').show();
            }
        });
        $(this).parent().parent().remove();
    });

</script>
</body>
</html>