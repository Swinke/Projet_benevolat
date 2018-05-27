<?php

if($_GET) {
    $d = $_GET['date'];
    $dated = date("Y-m-d",strtotime("$d"));
    $datef = date("Y-m-d",strtotime("$dated +1 day"));
    $month = date('m',strtotime("$d"));
    $day = date('D',strtotime("$d"));
}
else {
    $dated = date("Y-m-d",strtotime("last Monday"));
    $datef = date("Y-m-d",strtotime("next Saturday"));
}
$day = strtolower($day);

if($_GET['heure'] == 3)
    $heuremin = 0;
else if($_GET['heure'] == 6)
    $heuremin = 3;
else if($_GET['heure'] == 12)
    $heuremin = 6;
else
    $heuremin = 12;

$mysqli = new mysqli("localhost","root","","gestionbenevole");

$sql = "SELECT idActivite FROM activite WHERE nom = '".$_GET['act']."'";
$idact = $mysqli->query($sql)->fetch_assoc();

$sql = "SELECT dispo FROM activite WHERE idActivite = ".$idact['idActivite'];
$dispo = $mysqli->query($sql)->fetch_assoc();
$dispo['dispo'] = strtolower($dispo['dispo']);

if($_GET['heure'] == 0) {
    $sql = "SELECT nom, prenom, idBenevole as id FROM benevole
    WHERE idBenevole NOT IN (SELECT idBenevole FROM benevole_activite WHERE MONTH(start) = ".$month.")
    AND benevole.idBenevole IN (SELECT idBenevole FROM benevole_charge 
                                GROUP BY idBenevole HAVING MAX(idCharge) >= (SELECT MAX(idCharge) FROM activite_charge
                                                                            WHERE idActivite =".$idact['idActivite'].")
    AND benevole.idBenevole IN (SELECT idBenevole FROM benevole_dispo
                                WHERE dispo = '".$dispo['dispo']."'
                                 AND jour = '".$day."'))";
} else if($_GET['heure'] < 13) {
    $sql = "SELECT DISTINCT nom, prenom, benevole.idBenevole as id FROM benevole, benevole_activite
        WHERE benevole.idBenevole IN (SELECT idBenevole FROM benevole_activite
                                WHERE MONTH(start) = ".$month."
                                GROUP BY idBenevole HAVING SUM(TIMESTAMPDIFF(HOUR,start,end)) > ".$heuremin.
                                " AND SUM(TIMESTAMPDIFF(HOUR,start,end)) <=".$_GET['heure'].")
        AND benevole.idBenevole NOT IN (SELECT idBenevole FROM benevole_activite
                                        WHERE start BETWEEN '".$dated."' AND '".$datef."')
        AND benevole.idBenevole IN (SELECT idBenevole FROM benevole_charge 
                                    GROUP BY idBenevole HAVING MAX(idCharge) >= (SELECT MAX(idCharge) FROM activite_charge
                                                                                WHERE idActivite =".$idact['idActivite'].")
        AND benevole.idBenevole IN (SELECT idBenevole FROM benevole_dispo
                                    WHERE dispo = '".$dispo['dispo']."'
                                     AND jour = '".$day."'))";

} else {
    $sql = "SELECT DISTINCT nom, prenom, benevole.idBenevole as id FROM benevole, benevole_activite
        WHERE benevole.idBenevole IN (SELECT idBenevole FROM benevole_activite
                                    WHERE MONTH(start) = ".$month."
                                    GROUP BY idBenevole HAVING SUM(TIMESTAMPDIFF(HOUR,start,end)) > ".$heuremin.")
        AND benevole.idBenevole NOT IN (SELECT idBenevole FROM benevole_activite
                                        WHERE start BETWEEN '".$dated."' AND '".$datef."')
        AND benevole.idBenevole IN (SELECT idBenevole FROM benevole_charge 
                                    GROUP BY idBenevole HAVING MAX(idCharge) >= (SELECT MAX(idCharge) FROM activite_charge
                                                                                WHERE idActivite =".$idact['idActivite'].")
        AND benevole.idBenevole IN (SELECT idBenevole FROM benevole_dispo
                                    WHERE dispo = '".$dispo['dispo']."'
                                     AND jour = '".$day."'))";
}

$benevole = array();
$res = $mysqli->query($sql);
if($res) {
    while($row = $res->fetch_assoc()) {
        $benevole[] = $row;
    }
}
echo json_encode($benevole);
?>