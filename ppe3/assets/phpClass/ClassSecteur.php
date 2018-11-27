<?php

class Secteur
{
    private $secCode;
    private $secLibelle;

    public function __construct($secCode,$secLibelle)
    {
        $this->secCode = $secCode;
        $this->secLibelle = $secLibelle;
    }

    public function getSecCode()
    {
        return $this->secCode;
    }

    public function getSecLibelle()
    {
        return $this->secLibelle;
    }


}