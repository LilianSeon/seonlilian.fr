<?php
require 'ClassFamille.php';

class Medicaments
{
    private $nomMedic;
    private $depotLegal;
    private $effetMedic;
    private $contreIndic;
    private $prixMedic;

    private $famille = null;

    public function __construct($nomMedic, $depotLegal, $effetMedic, $contreIndic, $prixMedic)
    {
        $this->nomMedic = $nomMedic;
        $this->depotLegal = $depotLegal;
        $this->effetMedic = $effetMedic;
        $this->contreIndic = $contreIndic;
        $this->prixMedic = $prixMedic;
    }


    static function getAllMedicaments()
    {
        $bdd = new BDD();
        $bdd->query('SELECT * FROM medicament JOIN famille ON medicament.FAM_CODE = famille.FAM_CODE');
        $row = $bdd->resultset();

        $medicaments = [];
        foreach ($row as $value)
        {
            $medicament = new Medicaments(
                $value['MED_NOMCOMMERCIAL'],
                $value['MED_DEPOTLEGAL'],
                $value['MED_EFFETS'],
                $value['MED_CONTREINDIC'],
                $value['MED_PRIXECHANTILLON']);
            $medicament->setFamille($value['FAM_CODE'], $value['FAM_LIBELLE']);
            $medicaments[] = $medicament;
        }
        return $medicaments;
    }

    static function getAllDepotAndName()
    {
        $bdd = new BDD();
        $bdd->query('SELECT MED_DEPOTLEGAL, MED_NOMCOMMERCIAL FROM medicament');
        $row = $bdd->resultset();
        return $row;
    }

    public function setFamille($familleCode, $familleLib)
    {
        $this->famille = new Famille($familleCode, $familleLib);
    }

    public function getFamille()
    {
        return $this->famille;
    }

    public function getNomMedic()
    {
        return $this->nomMedic;
    }

    public function getDepotLegal()
    {
        return $this->depotLegal;
    }

    public function getEffetMedic()
    {
        return $this->effetMedic;
    }

    public function getContreIndic()
    {
        return $this->contreIndic;
    }

    public function getPrixMedic()
    {
        return $this->prixMedic;
    }

}