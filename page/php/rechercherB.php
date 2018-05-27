<?php
    $benevole = array();
    if($_POST) {
        
        $mysqli = new mysqli("localhost","root","","gestionbenevole");

        $sql = "SELECT idBenevole, nom, prenom, sexe, app, rue, cp, tel, date, courriel, civique, langue, logement, menage, source_revenu, occupation, statut, permis, vehicule"
                ." FROM benevole WHERE nom='".$_POST['nom']."' AND prenom='".$_POST['prenom']."'";

        $res = $mysqli->query($sql);
        if($res) {
            $benevole = $res->fetch_assoc();
            $benevole['erreur'] = false;
        }
        else
            $benevole['erreur'] = true;
    }
    echo json_encode($benevole);
?>