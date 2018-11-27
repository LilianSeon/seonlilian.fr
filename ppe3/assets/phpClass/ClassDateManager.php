<?php

class DateManager
{
    public function __construct()
    {
    }

    /**
     * Transforme une date au format français jj/mm/aaaa vers le format anglais aaaa-mm-jj
     * @param $madate au format  jj/mm/aaaa
     * @return false|string
     */
    static function dateFrancaisVersAnglais($maDate)
    {
        @list($jour, $mois, $annee) = explode('/', $maDate);
        return date('Y-m-d', mktime(0, 0, 0, $mois, $jour, $annee));
    }

    /**
     * Transforme une date au format format anglais aaaa-mm-jj vers le format français jj/mm/aaaa
     * @param $maDate
     * @return string
     * @internal param au $madate format  aaaa-mm-jj
     */
    static function dateAnglaisVersFrancais($maDate)
    {
        @list($annee, $mois, $jour) = explode('-', $maDate);
        $date = "$jour" . "/" . $mois . "/" . $annee;
        return $date;
    }
}