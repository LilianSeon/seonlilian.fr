<?php
require 'ClassPraticien.php';
require 'ClassVisiteur.php';
require 'ClassOffrir.php';
require 'ClassPresenter.php';


class RapportVisite
{
    private $numeroRapport;
    private $dateRapport;
    private $bilanRapport;
    private $motifRapport;

    private $praticien = null;
    private $visiteur = null;
    private $offrir = [];
    private $presenter = [];

    public function __construct($numeroRapport, $dateRapport, $bilanRapport, $motifRapport)
    {
        $this->numeroRapport = $numeroRapport;
        $this->dateRapport = $dateRapport;
        $this->bilanRapport = $bilanRapport;
        $this->motifRapport = $motifRapport;
    }

    static function getAllRapports()
    {
        $bdd = new BDD();
        $bdd->query('SELECT RAP.*, OFF.MED_DEPOTLEGAL AS OFF_MED_DEPOTLEGAL, OFF.OFF_QTE,OFF.SAISIE_DEF, PRE.MED_DEPOTLEGAL AS PRE_MED_DEPOTLEGAL, PRE.DOCUMENTATION, VIS.*, PRA.*
                      FROM rapport_visite RAP
                       JOIN visiteur VIS ON (RAP.VIS_MATRICULE = VIS.VIS_MATRICULE)
                        JOIN praticien PRA ON (RAP.PRA_NUM = PRA.PRA_NUM)
                         JOIN offrir OFF ON (RAP.RAP_NUM = OFF.RAP_NUM)
                          JOIN presenter PRE ON (RAP.RAP_NUM = PRE.RAP_NUM)
                       ');
        $row = $bdd->resultset();

        $rapports = [];
        foreach ($row as $value)
        {
            $RapportExiste = false;

            foreach ($rapports as $listeRapport)
            {
                if ($listeRapport->getNumeroRapport() === $value['RAP_NUM'])
                {
                    $RapportExiste = true;
                    if ($value['OFF_MED_DEPOTLEGAL'] !== null && $value['OFF_QTE'] !== null)
                    {
                        $offrir = new Offrir($value['OFF_MED_DEPOTLEGAL'], $value['OFF_QTE'],$value['SAISIE_DEF']);
                        if (!in_array($offrir, $listeRapport->getOffrir()))
                        {
                            $listeRapport->setOffrir($offrir);
                        }
                    }
                    if ($value['PRE_MED_DEPOTLEGAL'] !== null && $value['DOCUMENTATION'] !== null)
                    {
                        $presenter = new Presenter($value['PRE_MED_DEPOTLEGAL'], $value['DOCUMENTATION']);
                        if (!in_array($presenter, $listeRapport->getPresenter()))
                        {
                            $listeRapport->setPresenter($presenter);
                        }
                    }

                    break;
                }
            }

            if (!$RapportExiste)
            {
                $rapport = new RapportVisite(
                    $value['RAP_NUM'],
                    $value['RAP_DATE'],
                    $value['RAP_BILAN'],
                    $value['RAP_MOTIF']
                );

                $rapport->setVisiteur(
                    $value['VIS_MATRICULE'],
                    $value['VIS_NOM'],
                    $value['VIS_PRENOM'],
                    $value['VIS_VILLE'],
                    $value['VIS_ADRESSE'],
                    $value['VIS_CP'],
                    $value['VIS_DATEEMBAUCHE']
                );

                $rapport->setPraticien(
                    $value['PRA_NUM'],
                    $value['PRA_NOM'],
                    $value['PRA_PRENOM'],
                    $value['PRA_ADRESSE'],
                    $value['PRA_CP'],
                    $value['PRA_VILLE'],
                    $value['PRA_COEFNOTORIETE']
                );

                if ($value['OFF_MED_DEPOTLEGAL'] !== null && $value['OFF_QTE'] !== null)
                {
                    $offrir = new Offrir($value['OFF_MED_DEPOTLEGAL'], $value['OFF_QTE'],$value['SAISIE_DEF']);
                    if (!in_array($offrir, $rapport->getOffrir()))
                    {
                        $rapport->setOffrir($offrir);
                    }
                }

                if ($value['PRE_MED_DEPOTLEGAL'] !== null && $value['DOCUMENTATION'] !== null)
                {
                    $presenter = new Presenter($value['PRE_MED_DEPOTLEGAL'], $value['DOCUMENTATION']);
                    if (!in_array($presenter, $rapport->getPresenter()))
                    {
                        $rapport->setPresenter($presenter);
                    }
                }
                $rapports[] = $rapport;
            }
        }

        return $rapports;
    }

    public function setPraticien($num, $nom, $prenom, $adresse, $cp, $ville, $coef)
    {
        $this->praticien = new Praticien($num, $nom, $prenom, $adresse, $cp, $ville, $coef);
    }

    public function getPraticien()
    {
        return $this->praticien;
    }

    public function setVisiteur($matricule, $nom, $prenom, $ville, $adresse, $cp, $dateEmbauche)
    {
        $this->visiteur = new Visiteur($matricule, $nom, $prenom, $ville, $adresse, $cp, $dateEmbauche);
    }

    public function getVisiteur()
    {
        return $this->visiteur;
    }

    public function setOffrir($offrir)
    {
        $this->offrir[] = $offrir;
    }

    public function getOffrir()
    {
        return $this->offrir;
    }

    public function setPresenter($presenter)
    {
        $this->presenter[] = $presenter;
    }

    public function getPresenter()
    {
        return $this->presenter;
    }

    public function getNumeroRapport()
    {
        return $this->numeroRapport;
    }

    public function setNumeroRapport($numeroRapport)
    {
        $this->numeroRapport = $numeroRapport;
    }

    public function getDateRapport()
    {
        return $this->dateRapport;
    }

    public function setDateRapport($dateRapport)
    {
        $this->dateRapport = $dateRapport;
    }


    public function getBilanRapport()
    {
        return $this->bilanRapport;
    }

    public function setBilanRapport($bilanRapport)
    {
        $this->bilanRapport = $bilanRapport;
    }

    public function getMotifRapport()
    {
        return $this->motifRapport;
    }

    public function setMotifRapport($motifRapport)
    {
        $this->motifRapport = $motifRapport;
    }

}