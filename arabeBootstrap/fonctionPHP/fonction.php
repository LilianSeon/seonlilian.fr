<?php

function NbrRandom(){

	$nb = rand(1,28);

	return $nb;
}

function CorrectionEx1($nb, $msg){


	switch ($nb) {
		case '1':
			if ($msg == "alif" || $msg == "Alif") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '2':
			if ($msg == "ba" || $msg == "Ba") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '3':
			if ($msg == "ta" || $msg == "Ta") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '4':
			if ($msg == "tha" || $msg == "Tha") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '5':
			if ($msg == "jim" || $msg == "Jim") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '6':
			if ($msg == "ha" || $msg == "Ḥa" || $msg == "Ha") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '7':
			if ($msg == "kha" || $msg == "Kha") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '8':
			if ($msg == "dal" || $msg == "Dal") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '9':
			if ($msg == "dhal" || $msg == "Dhal") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '10':
			if ($msg == "ra" || $msg == "Ra") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '11':
			if ($msg == "zay" || $msg == "Zay") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '12':
			if ($msg == "sin" || $msg == "Sin") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '13':
			if ($msg == "shin" || $msg == "šin" || $msg == "Shin") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '14':
			if ($msg == "sad" || $msg == "Sad") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '15':
			if ($msg == "dad" || $msg == "Dad") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '16':
			if ($msg == "ta" || $msg == "Ta") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '17':
			if ($msg == "za" || $msg == "Za") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '18':
			if ($msg == "ayn" || $msg =="'ayn" || $msg == "Ayn") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '19':
			if ($msg == "ghayn" || $msg == "Ghayn") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '20':
			if ($msg == "fa" || $msg == "Fa") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '21':
			if ($msg == "qaf" || $msg == "Qaf") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '22':
			if ($msg == "kaf" || $msg == "Kaf") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '23':
			if ($msg == "lam" || $msg == "Lam") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '24':
			if ($msg == "mim" || $msg == "Mim") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '25':
			if ($msg == "nun" || $msg == "Nun") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '26':
			if ($msg == "ha" || $msg == "Ha") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '27':
			if ($msg == "waw" || $msg == "Waw") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
		case '28':
			if ($msg == "ya" || $msg == "Ya") {
				$resultat = "true";
			}else{
				$resultat = "false";
			}
			break;
	}

	return $resultat;
}

function Helper($nb){

	switch ($nb) {
		case '1':
			$lettre = "alif";
			break;
		case '2':
			$lettre = "ba";
			break;
		case '3':
			$lettre = "ta";
			break;
		case '4':
			$lettre = "tha";
			break;
		case '5':
			$lettre = "jim";
			break;
		case '6':
			$lettre = "ha";
			break;
		case '7':
			$lettre = "kha";
			break;
		case '8':
			$lettre = "dal";
			break;
		case '9':
			$lettre = "dhal";
			break;
		case '10':
			$lettre = "ra";
			break;
		case '11':
			$lettre = "zay";
			break;
		case '12':
			$lettre = "sin";
			break;
		case '13':
			$lettre = "shin";
			break;
		case '14':
			$lettre = "sad";
			break;
		case '15':
			$lettre = "dad";
			break;
		case '16':
			$lettre = "ta";
			break;
		case '17':
			$lettre = "za";
			break;
		case '18':
			$lettre = "ayn";
			break;
		case '19':
			$lettre = "ghayn";
			break;
		case '20':
			$lettre = "fa";
			break;
		case '21':
			$lettre = "qaf";
			break;
		case '22':
			$lettre = "kaf";
			break;
		case '23':
			$lettre = "lam";
			break;
		case '24':
			$lettre = "mim";
			break;
		case '25':
			$lettre = "nun";
			break;
		case '26':
			$lettre = "ha";
			break;
		case '27':
			$lettre = "waw";
			break;
		case '28':
			$lettre = "ya";
			break;
	}
	return $lettre;
}

function Compteur(){

$filename = 'test.txt';
if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '78.232.97.183')
$somecontent=$_SERVER['HTTP_X_FORWARDED_FOR']." ".$_SERVER['HTTP_USER_AGENT']." ".$_SERVER['REDIRECT_REMOTE_USER']." ".date("F j, Y, g:i a");
else
$somecontent=$_SERVER['REMOTE_ADDR']." ".$_SERVER['HTTP_USER_AGENT'];
if (is_writable($filename)) { // Si le fichier est écrivable
    if (!$handle = fopen($filename, 'a')) { // !! Position du curseur php
        exit;
    }
    if (fwrite($handle, $somecontent."\r\n") === FALSE) { // Ecriture de l'ip
        exit;
    }
    fclose($handle);
} 
}

function Combo($cor, $combo){
	
	if ($cor == "true") {
		$combo++;
	}else{
		$combo = 0;
	}

	return $combo;
}
?>