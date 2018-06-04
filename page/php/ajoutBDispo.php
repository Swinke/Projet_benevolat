<?php
    $erreur = array();
    $heure = array();
    $jour = ["mon","tue","wed","fri","sat","thu"];
    if($_POST) {
        foreach($_POST as $name => $value) {
            if($value == "")
                $erreur[$name] = "true";
        }
        if(!$erreur){
            if($_POST['dispo']=='7h-14h') {
                $heure['debut'] = '07:00:00';
                $heure['fin'] = '14:00:00';
            } else if($_POST['dispo']=='9h-12h') {
                $heure['debut'] = '09:00:00';
                $heure['fin'] = '12:00:00';
            } else {
                $heure['debut'] = '14:00:00';
                $heure['fin'] = '17:00:00';
            }
            $mysqli = new mysqli("localhost","root","","testbenevolat");

            $sql = "SELECT idBenevole FROM benevole WHERE nom = '".$_POST['nom']."' AND prenom = '".$_POST['prenom']."'";
            $idB = $mysqli->query($sql)->fetch_assoc();

            foreach($_POST as $nom) {
                if(in_array($nom,$jour)) {
                    $sql = "INSERT INTO benevole_dispo(idBenevole, jour, heure_debut,heure_fin) VALUES (".$idB['idBenevole'].",'".$nom."','".$heure['debut']."','".$heure['fin']."')";
                    $res = $mysqli->query($sql);
                }
            }
        }
    }
    echo json_encode($_POST);
?>