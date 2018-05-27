<?php
if($_GET) {
    if($_GET['jour']=='true') {
        $d = $_GET['date'];
        $dated = date("y-m-d",strtotime("$d"));
        $datef = date("y-m-d",strtotime("$dated +1 day"));
    }else {
        $d = $_GET['date'];
        $dated = date("y-m-d",strtotime("$d next Monday"));
        $datef = date("y-m-d",strtotime("$dated next Saturday"));
    }
} else {
    $dated = date("y-m-d",strtotime("last Monday"));
    $datef = date("y-m-d",strtotime("next Saturday"));
}

$datetemp = date("y-m-d",strtotime("$dated +1 day"));
$mysqli = new mysqli("localhost","root","","gestionbenevole");
$events = array();
$nbrpers = array();
$rep = array();
$temp = array();

$sql = "SELECT nom, mon, tue, wed, thu, fri FROM activite";
$res = $mysqli->query($sql);
while($row = $res->fetch_assoc()) {
    $nbrpers[] = $row;
}
while($dated != $datef) {
    $sql = "SELECT count(numero), nom FROM benevole_activite, activite WHERE start >= '"
            .$dated."' AND start < '"
            .$datetemp."' AND benevole_activite.idActivite = activite.idActivite"
            ." GROUP BY nom";       
    $res = $mysqli->query($sql);
    while($row = $res->fetch_assoc()) {
        $events[] = $row;
    }
    $jour = strtolower(date("D",strtotime("$dated")));
    foreach($nbrpers as $value) {
        $temp[$value['nom']] = $value[$jour];
    }
    if($events) {
        foreach($events as $ligne) {
            $i = 0;
            while($i<sizeof($nbrpers) && $nbrpers[$i]['nom'] != $ligne['nom'])
                $i++;
            if($i<sizeof($nbrpers)) {
                $temp[$ligne['nom']] = $nbrpers[$i][$jour] - $ligne['count(numero)'];
            }
        }
    }

    $rep[$jour] = $temp;
    $events = array();
    $temp = array();
    $dated = date("y-m-d",strtotime("$dated +1 day"));
    $datetemp = date("y-m-d",strtotime("$datetemp +1 day"));
}
echo json_encode($rep);
?>