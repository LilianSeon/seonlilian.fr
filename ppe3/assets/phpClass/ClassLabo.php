<?php

class Labo
{
    private $labCode;
    private $labNom;
    private $labChef;


    public function __construct($labCode,$labNom,$labChef)
    {
        $this->labCode = $labCode;
        $this->labNom = $labNom;
        $this->labChef = $labChef;
    }

    public function getLabCode()
    {
        return $this->labCode;
    }

    public function getLabNom()
    {
        return $this->labNom;
    }

    public function getLabChef()
    {
        return $this->labChef;
    }


}