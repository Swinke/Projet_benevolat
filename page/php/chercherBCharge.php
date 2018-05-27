<?php
    $benevole = array();
    if($_POST) {
        
        $mysqli = new mysqli("localhost","root","","gestionbenevole");

        $sql = "SELECT poids as nom FROM charge, benevole_charge"
                ." WHERE benevole_charge.idBenevole=".$_POST['id']." AND benevole_charge.idCharge = charge.idCharge";

        $res = $mysqli->query($sql);
        if($res) {
            while($row = $res->fetch_assoc()) {
                $benevole[] = $row['nom'];
            }
            $benevole['erreur'] = false;
        }
        else
            $benevole['erreur'] = true;
    }
    echo json_encode($benevole);
?>