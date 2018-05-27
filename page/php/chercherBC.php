<?php
    $benevole = array();
    if($_POST) {
        
        $mysqli = new mysqli("localhost","root","","gestionbenevole");

        $sql = "SELECT nom FROM competence, benevole_competence"
                ." WHERE benevole_competence.idBenevole=".$_POST['id']." AND benevole_competence.idComp = competence.idComp";

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