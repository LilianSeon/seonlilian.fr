<?php
header('Location: ../view/nouveauCR.php?');
error_reporting(e_all);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

require('ScriptBDD.php');
require('../phpClass/ClassPraticien.php');
require('../phpClass/ClassDateManager.php');

session_start();
$sessionId = $_SESSION['id'];


$rapportDate = DateManager::dateFrancaisVersAnglais($_POST['rapportDate']);
$rapportPraticien = $_POST['rapportPraticien'];
$rapportBilan = filter_input(INPUT_POST, 'rapportBilan', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$rapportMotif = filter_input(INPUT_POST, 'rapportMotif', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$compteElem = $_POST['compteElem'];
$compteEchant = $_POST['compteEchant'];
$praticienEstRemplace = false;


if ($rapportPraticien === null || $rapportBilan === null || $rapportDate === null)
{
    header('Location: ../view/nouveauCR.php?e=1');
    exit;
}

if (isset($_POST['rapportIsRemplace']))
{
    $remplacantNom = $_POST['remplacantNom'];
    $remplacantPrenom = $_POST['remplacantPrenom'];
    $remplacantAdresse = $_POST['remplacantAdresse'];
    $remplacantVille = $_POST['remplacantVille'];
    $remplacantCP = $_POST['remplacantCP'];
    $remplacantCoef = $_POST['remplacantCoef'];
    $remplacantTypePra = $_POST['remplacantTypePra'];
# /!\
    $praticienEstRemplace = true;
# /!\
} else
{
    unset($_POST['remplacantNom'],
        $_POST['remplacantPrenom'],
        $_POST['remplacantAdresse'],
        $_POST['remplacantVille'],
        $_POST['remplacantCP'],
        $_POST['remplacantCoef'],
        $_POST['remplacantTypePra']
    );
}

switch ($rapportMotif)
{
    case '1':
        $rapportMotif = 'Périodicité';
        break;
    case '2':
        $rapportMotif = 'Actualisation';
        break;
    case '3':
        $rapportMotif = 'Relance';
        break;
    case '4':
        $rapportMotif = 'Solicitation Praticien';
        break;
    case '5':
        $rapportMotif = 'Autre';
}
if ($rapportMotif === 'Autre')
{
    $rapportMotif = $_POST['autreMotif'];
}

#récupération des lignes des éléments présentés :
$elementExiste = false;
if (isset($_POST['selectElem0']))
{
    $ElementsPresentes = [];
    for ($i = $compteElem; $i >= 0; $i--)
    {
        if (isset($_POST['selectElem' . $i]))
        {
            if (isset($_POST['documentation' . $i]))
                $_POST['documentation' . $i] = true;
            else
                $_POST['documentation' . $i] = false;

            $ElementsPresentes['Elem' . $i] =
                [
                    'RAP_NUM' => '',
                    'MED_DEPOTLEGAL' => $_POST['selectElem' . $i],
                    'DOCUMENTATION' => $_POST['documentation' . $i]
                ];
        }
    }
    $elementExiste = true;
}
#récupération des lignes des échantillons offerts :
$echantillonExiste = false;
if (isset($_POST['selectEchant0']))
{
    $EchantillonsOfferts = [];
    for ($i = $compteEchant; $i >= 0; $i--)
    {
        if (isset($_POST['selectEchant' . $i]))
        {
            if (isset($_POST['saisieDef' . $i]))
                $_POST['saisieDef' . $i] = true;
            else
                $_POST['saisieDef' . $i] = false;

            $EchantillonsOfferts['Echant' . $i] =
                [
                    'RAP_NUM' => '',
                    'MED_DEPOTLEGAL' => $_POST['selectEchant' . $i],
                    'OFF_QTE' => $_POST['offQte' . $i],
                    'SAISIE_DEF' => $_POST['saisieDef' . $i]
                ];
        }
    }
    $echantillonExiste = true;
}


#transaction du tout :
try
{
#debut
    $bdd = new BDD();
    $bdd->beginTransaction();


    $remplacantId = null;
    if ($praticienEstRemplace)
    {
        $remplacantVille = strtoupper($remplacantVille);

        $nouveauPraticien = $bdd->query('INSERT INTO praticien(PRA_NOM,PRA_PRENOM,PRA_ADRESSE,PRA_CP,PRA_VILLE,PRA_COEFNOTORIETE,TYP_CODE)
        VALUE (:nom,:prenom,:adresse,:cp,:ville,:coef,:typeCode)');
        $nouveauPraticien->bindValue(':nom', $remplacantNom);
        $nouveauPraticien->bindValue(':prenom', $remplacantPrenom);
        $nouveauPraticien->bindValue(':adresse', $remplacantAdresse);
        $nouveauPraticien->bindValue(':cp', $remplacantCP);
        $nouveauPraticien->bindValue(':ville', $remplacantVille);
        $nouveauPraticien->bindValue(':coef', $remplacantCoef);
        $nouveauPraticien->bindValue(':typeCode', $remplacantTypePra);
        $nouveauPraticien->execute();


        $remplacantId = $bdd->lastInsertId();
    }


#table rapport_visite
    $rapport = $bdd->query('INSERT INTO rapport_visite (VIS_MATRICULE, PRA_NUM,RAP_REMPLACANT, RAP_DATE, RAP_BILAN, RAP_MOTIF)
                VALUE (:visiteur,:praticien,:remplacant,:rapportDate,:bilan,:motif)');
    $rapport->bindValue(':visiteur', $sessionId);
    $rapport->bindValue(':praticien', $rapportPraticien);
    $rapport->bindValue(':remplacant', $remplacantId);
    $rapport->bindValue(':rapportDate', $rapportDate);
    $rapport->bindValue(':bilan', $rapportBilan);
    $rapport->bindValue(':motif', $rapportMotif);
    $rapport->execute();
    $numeroRapport = $bdd->lastInsertId();

#insérer les éléments présentés :
    if ($elementExiste === true)
    {
        $presentes = $bdd->query('INSERT INTO presenter (RAP_NUM, MED_DEPOTLEGAL, DOCUMENTATION) 
              VALUE (:RAP_NUM,:MED_DEPOTLEGAL,:DOCUMENTATION)');

        foreach ($ElementsPresentes as $row)
        {
            $row['RAP_NUM'] = $numeroRapport;
            $presentes->execute($row);
        }
    }

#insérer les échantillons offerts :
    if ($echantillonExiste === true)
    {
        $offerts = $bdd->query('INSERT INTO offrir (RAP_NUM, MED_DEPOTLEGAL,OFF_QTE, SAISIE_DEF)
            VALUE (:RAP_NUM,:MED_DEPOTLEGAL,:OFF_QTE,:SAISIE_DEF)');

        foreach ($EchantillonsOfferts as $row)
        {
            $row['RAP_NUM'] = $numeroRapport;
            $offerts->execute($row);
        }
    }
#fin
    $bdd->endTransaction();

    header('Location: ../view/nouveauCR.php?e=0');
}
catch (PDOException $e)
{
    $errorM = "<pre>" . $e . "<br/>" . $e->getMessage() . "</pre>";
    echo $errorM;
    $bdd->cancelTransaction();
} finally {
      header('Location: ../view/nouveauCR.php?e=2');
}