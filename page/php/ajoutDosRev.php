<?php
    $erreur = array();
    if($_POST) {
        foreach($_POST as $name => $value) {
            if($name != "montant") {
                if($value == "")
                    $erreur[$name] = "true";
            }
        }
        if(!$erreur){
            $mysqli = new mysqli("localhost","root","","testbenevolat");

            $sql = "SELECT idBenevole FROM benevole WHERE nom = '".$_POST['nom']."' AND prenom = '".$_POST['prenom']."'";
            $idB = $mysqli->query($sql)->fetch_assoc();

            if(!array_key_exists('preuve_revenu',$_POST))
                $_POST['preuve_revenu'] ="";
            if(!array_key_exists('preuve_adresse',$_POST))
                $_POST['preuve_adresse'] ="";
            if(!array_key_exists('carte_id',$_POST))
                $_POST['carte_id'] ="";
            if(!array_key_exists('cotisation',$_POST))
                $_POST['cotisation'] ="";
            if(!$_POST['montant'])
                $_POST['montant'] = 0;

            $sql = "INSERT INTO benevole_dosrevenu(idB, preuve_revenu, preuve_adresse, carte_id, cotisation, montant)"
                    ." VALUES (".$idB['idBenevole'].",'".$_POST['preuve_revenu']."','".$_POST['preuve_adresse']."','".$_POST['carte_id']."'"
                    .",'".$_POST['cotisation']."','".$_POST['montant']."')";
            $res = $mysqli->query($sql);
        }
    }
    echo json_encode($res);
?>