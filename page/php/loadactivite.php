<?php
$mysqli = new mysqli("localhost","root","","gestionbenevole");
$sql = 'SELECT nom as title
        FROM activite';
$events = array();
$res = $mysqli->query($sql);
while($row = $res->fetch_assoc()) {
    $events[] = $row;
}
echo json_encode($events);
?>