<?php

$name_event = "";

if($_GET) {
    if($_GET['jour']=='true') {
        $d = $_GET['date'];
        $dated = date("Y-m-d",strtotime("$d"));
        $datef = date("Y-m-d",strtotime("$dated +1 day"));
    }else {
        $d = $_GET['date'];
        $dated = date("Y-m-d",strtotime("$d next Monday"));
        $datef = date("Y-m-d",strtotime("$dated next Saturday"));
    }
    foreach($_GET as $name => $value) {
        if($name != "jour" && $name != "date") {
            if($value == 'false')
                $name_event .= "'".$name."',";
        }
    }
    if($name_event != "")
        $name_event = substr($name_event,0,-1);
} else {
    $dated = date("Y-m-d",strtotime("last Monday"));
    $datef = date("Y-m-d",strtotime("next Saturday"));
}

$datetemp = date("Y-m-d",strtotime("$dated +1 day"));

$eventexist = array();

$mysqli = new mysqli("localhost","root","","gestionbenevole");

$sql = "SELECT nom, mon, tue, wed, thu, fri, Astart, Aend FROM activite";
if($name_event != "") {
    $sql .= " WHERE nom NOT IN (".$name_event.")";
}

$res = $mysqli->query($sql);
while($row = $res->fetch_assoc()) {
    $nbrpers[] = $row;
}

$sql = "SELECT nom FROM activite";
$res = $mysqli->query($sql);
$nomact = $res->fetch_assoc();

$sql = 'SELECT benevole.nom, activite.nom as title, benevole.prenom, numero as id, start, end
        FROM benevole, benevole_activite, activite
        WHERE benevole.idBenevole = benevole_activite.idBenevole
        AND benevole_activite.idActivite = activite.idActivite';

if($name_event != "") {
    $sql .= " AND activite.nom NOT IN (".$name_event.")";
}

$events = array();
$res = $mysqli->query($sql);
while($row = $res->fetch_assoc()) {
    $events[] = $row;
}

while($dated != $datef) {
    $sql = "SELECT count(numero), nom FROM benevole_activite, activite WHERE start >= '"
            .$dated."' AND start < '"
            .$datetemp."' AND benevole_activite.idActivite = activite.idActivite
            GROUP BY nom";
    
    $res = $mysqli->query($sql);
    while($row = $res->fetch_assoc()) {
        $eventexist[] = $row;
    }
    $jour = strtolower(date("D",strtotime("$dated")));
    $i = 0;
    while($i < sizeof($nbrpers)) {
        $j = 0;
        while($j<sizeof($eventexist) && $eventexist[$j]['nom'] != $nbrpers[$i]['nom']){
            $j++;
        }
        if($j < sizeof($eventexist))
            $nbreventm = $nbrpers[$i][$jour] - $eventexist[$j]['count(numero)'];
        else
            $nbreventm = $nbrpers[$i][$jour];
        $compt = 0;
        if($nbreventm > 0) {
            while($compt < $nbreventm) {
                $temp['title'] = $nbrpers[$i]['nom'];
                $temp['start'] = $dated."T".$nbrpers[$i]['Astart'];
                $temp['end'] = $dated."T".$nbrpers[$i]['Aend'];
                $compt++;
                $events[] = $temp;
                $temp = array();
            }
        }
        $i++;
    }
    $eventexist = array();
    
    $dated = date("Y-m-d",strtotime("$dated +1 day"));
    $datetemp = date("Y-m-d",strtotime("$datetemp +1 day"));
}
echo json_encode($events);
?>