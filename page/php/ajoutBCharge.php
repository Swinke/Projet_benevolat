<?php
    $erreur = array();
    $listecomp = array();
    if($_POST) {
        foreach($_POST as $name => $value) {
            if($value == "")
                $erreur[$name] = "true";
        }
        if(!$erreur){
            $mysqli = new mysqli("localhost","root","","testbenevolat");

            $sql = "SELECT idBenevole FROM benevole WHERE nom = '".$_POST['nom']."' AND prenom = '".$_POST['prenom']."'";
            $idB = $mysqli->query($sql)->fetch_assoc();

            foreach($_POST as $poids) {
                $sql = "SELECT idCharge FROM charge WHERE poids ='".$poids."'";
                $idC = $mysqli->query($sql)->fetch_assoc();

                if($idC) {
                    $sql = "INSERT INTO benevole_charge(idBenevole, idCharge) VALUES (".$idB['idBenevole'].",".$idC['idCharge'].")";
                    $res = $mysqli->query($sql);
                }
            }
        }
    }
    echo json_encode($res);
?>