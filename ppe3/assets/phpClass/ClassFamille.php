<?php


class Famille
{
    private $familleCode;
    private $familleLib;

    public function __construct($familleCode,$familleLib)
    {
        $this->familleLib = $familleLib;
        $this->familleCode = $familleCode;
    }

    public function getFamilleCode()
    {
        return $this->familleCode;
    }

    public function getFamilleLib()
    {
        return $this->familleLib;
    }
}