<?php


class TypePraticien
{
    private $typeCode;
    private $typeLibelle;
    private $typeLieu;

    public function __construct($typeCode,$typeLibelle,$typeLieu)
    {
        $this->typeCode = $typeCode;
        $this->typeLibelle = $typeLibelle;
        $this->typeLieu = $typeLieu;
    }

    public function getTypeCode()
    {
        return $this->typeCode;
    }
    public function getTypeLibelle()
    {
        return $this->typeLibelle;
    }

    public function getTypeLieu()
    {
        return $this->typeLieu;
    }


}