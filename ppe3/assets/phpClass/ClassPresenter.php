<?php

class Presenter
{
    private $medDepotlegal;
    private $documentation;

    public function __construct($medDepotlegal, $documentation)
    {
        $this->medDepotlegal = $medDepotlegal;
        $this->documentation = $documentation;
    }

    public function getMedDepotlegal()
    {
        return $this->medDepotlegal;
    }

    public function getDocumentation()
    {
        return $this->documentation;
    }

}