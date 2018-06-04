<?php
    $listeB = array();

    $mysqli = new mysqli("localhost","root","","testbenevolat");

    $sql = "SELECT idBenevole, nom, prenom, integration FROM benevole WHERE benevole.type_benevole = 'benevole' OR benevole.type_benevole = 'membre engage'";
    $res = $mysqli->query($sql);

    while($row = $res->fetch_assoc()) {
        $listeB[] = $row;
    }
    echo json_encode($listeB);
?>