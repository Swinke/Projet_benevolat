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

            foreach($_POST as $nom) {
                $sql = "SELECT idComp FROM competence WHERE nom ='".$nom."'";
                $idC = $mysqli->query($sql)->fetch_assoc();

                if($idC) {
                    $sql = "INSERT INTO benevole_competence(idBenevole, idComp) VALUES (".$idB['idBenevole'].",".$idC['idComp'].")";
                    $res = $mysqli->query($sql);
                }
            }
        }
    }
    echo json_encode($res);
?>