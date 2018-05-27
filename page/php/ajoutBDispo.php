<?php
    $erreur = array();
    $jour = ["mon","tue","wed","fri","sat","thu"];
    if($_POST) {
        foreach($_POST as $name => $value) {
            if($value == "")
                $erreur[$name] = "true";
        }
        if(!$erreur){
            $mysqli = new mysqli("localhost","root","","testbenevolat");

            $sql = "SELECT idBenevole FROM benevole WHERE nom = '".$_POST['nom']."' AND prenom = '".$_POST['prenom']."'";
            $idB = $mysqli->query($sql)->fetch_assoc();

            foreach($_POST as $nom) {
                if(in_array($nom,$jour)) {
                    $sql = "INSERT INTO benevole_dispo(idBenevole, jour, dispo) VALUES (".$idB['idBenevole'].",'".$nom."','".$_POST['dispo']."')";
                    $res = $mysqli->query($sql);
                }
            }
        }
    }
    echo json_encode($res);
?>