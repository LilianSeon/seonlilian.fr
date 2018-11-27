<?php

class User
{
    private $matricule = null;
    private $nom = null;
    private $prenom = null;
    private $adresse = null;
    private $ville = null;
    private $cp = null;
    private $dateEmbauche = null;


    public function __construct($matricule)
    {

        $bdd = new BDD();
        $bdd->query('SELECT VIS_MATRICULE,
                        VIS_NOM,
                        VIS_PRENOM,
                        VIS_ADRESSE,
                        VIS_CP,
                        VIS_VILLE,
                        VIS_DATEEMBAUCHE
                        FROM visiteur WHERE VIS_MATRICULE = :matricule');

        $bdd->bind(':matricule',$matricule);
        $rows = $bdd->single();
        $this->matricule = $rows['VIS_MATRICULE'];
        $this->nom = $rows['VIS_NOM'];
        $this->prenom = $rows['VIS_PRENOM'];
        $this->adresse = $rows['VIS_ADRESSE'];
        $this->ville = $rows['VIS_VILLE'];
        $this->cp = $rows['VIS_CP'];
        $this->dateEmbauche = $rows['VIS_DATEEMBAUCHE'];
    }


    public function getMatricule()
    {
        return $this->matricule;
    }


    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function getVille()
    {
        return $this->ville;
    }

    public function getCp()
    {
        return $this->cp;
    }


    public function getDateEmbauche()
    {
        return $this->dateEmbauche;
    }


}