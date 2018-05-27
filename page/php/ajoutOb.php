<?php
    $erreur = array();
    if($_POST) {
            $mysqli = new mysqli("localhost","root","","testbenevolat");

            $sql = "SELECT idBenevole FROM benevole WHERE nom = '".$_POST['nom']."' AND prenom = '".$_POST['prenom']."'";
            $idB = $mysqli->query($sql)->fetch_assoc();

            $sql = "INSERT INTO observation (id,charge,competence,dispo,autre) VALUES ('".$idB['idBenevole']."','".$_POST['ob_charge']."','".$_POST['ob_comp']."','".$_POST['ob_dispo']."','".$_POST['ob']."')";

            $res = $mysqli->query($sql);
            $erreur['correct'] = $res;
    }
    echo json_encode($erreur);
?>