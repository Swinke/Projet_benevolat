<?php
    $benevole = array();
    if($_POST) {
        
        $mysqli = new mysqli("localhost","root","","gestionbenevole");

        $sql = "SELECT jour FROM benevole_dispo"
                ." WHERE benevole_dispo.idBenevole=".$_POST['id']." AND benevole_dispo.dispo = '".$_POST['dispo']."'";

        $res = $mysqli->query($sql);
        if($res) {
            while($row = $res->fetch_assoc()) {
                $benevole[] = $row['jour'];
            }
            $benevole['erreur'] = false;
        }
        else
            $benevole['erreur'] = true;
    }
    echo json_encode($benevole);
?>