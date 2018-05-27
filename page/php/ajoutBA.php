<?php

$mysqli = new mysqli("localhost","root","","gestionbenevole");

$sql = "SELECT idBenevole FROM benevole WHERE '"
.$_POST['idBene']."'=idBenevole";
$res = $mysqli->query($sql)->fetch_assoc();
$id['idB'] = $res['idBenevole'];

$sql = "SELECT idActivite FROM activite WHERE '"
.$_POST['title']."'=nom";
$res = $mysqli->query($sql)->fetch_assoc();
$id['idA'] = $res['idActivite'];

$sql = "SELECT MAX(numero) as max FROM benevole_activite";
$res = $mysqli->query($sql)->fetch_assoc();
$id['numero'] = $res['max']+1;

$sql = "INSERT INTO benevole_activite (idBenevole, start, end, idActivite, numero)"
." VALUES ('".$id['idB']."','".$_POST['start']."','".$_POST['end'].
"','".$id['idA']."', '".$id['numero']."')";
$res = $mysqli->query($sql);

$rep = array();
if($res) {
    $sql = "SELECT nom, prenom FROM benevole WHERE idBenevole = '".$id['idB']."'";
    $res = $mysqli->query($sql)->fetch_assoc();
    $rep['nom'] = $res['nom'];
    $rep['prenom'] = $res['prenom'];
    $rep['id'] = $id['numero'];
}
echo json_encode($rep);
?>