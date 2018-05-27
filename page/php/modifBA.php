<?php
$mysqli = new mysqli("localhost","root","","testbenevolat");
$sql = "UPDATE benevole_activite SET start='"
.$_POST['start']."', end='"
.$_POST['end']."'WHERE numero='"
.$_POST['id']."'";

$res = $mysqli->query($sql)->fetch_assoc();
echo json_encode($res);
?>