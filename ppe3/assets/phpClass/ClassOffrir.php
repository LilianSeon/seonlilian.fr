<?php

class Offrir
{
    private $medDepotlegal;
    private $offrirQte;
    private $saisieDef;

    public function __construct($medDepotlegal, $offrirQte,$saisieDef)
    {
        $this->medDepotlegal = $medDepotlegal;
        $this->offrirQte = $offrirQte;
        $this->saisieDef = $saisieDef;
    }

    public function getMedDepotlegal()
    {
        return $this->medDepotlegal;
    }

    public function getSaisieDef()
    {
        return $this->saisieDef;
    }


    public function getOffrirQte()
    {
        return $this->offrirQte;
    }

}