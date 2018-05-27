<?php
    $erreur = array();
    if($_POST) {
        foreach($_POST as $name => $value) {
            if($value == "")
                $erreur[$name] = "true";
        }
        if(!$erreur){
            $mysqli = new mysqli("localhost","root","","gestionbenevole");

            $sql = "SELECT idBenevole FROM benevole WHERE nom='".$_POST['nom']."' AND prenom= '".$_POST['prenom']."'";
            $res = $mysqli->query($sql)->fetch_assoc();
            if($res) {
                $id['id'] = $res['idBenevole'];
            }

            $sql = "UPDATE benevole SET nom='".$_POST['nom']."', prenom='".$_POST['prenom']."', sexe='".$_POST['sexe']."', app='".$_POST['app']."'"
                        ."', rue=".$_POST['rue']."', cp='".$_POST['cp']."', tel='".$_POST['tel']."', date='".$_POST['date']."', courriel='".$_POST['courriel']."',"
                        ."civique='".$_POST['civique']."', langue= '".$_POST['langue']."', logement='".$_POST['logement']."', menage='".$_POST['menage']."',"
                        ."source_revenu='".$_POST['source_revenu']."', occupation = '".$_POST['occupation']."'"
                        ." WHERE idBenevole =".$id['id'];

                $res = $mysqli->query($sql);
                $erreur['modif'] = $res;
            
            $sql = "DELETE FROM benevole_comp WHERE idBenevole = '".$id['id']."'";
            $res = $mysqli->query($sql);
            $erreur['correct'] = $res;

            $sql = "DELETE FROM benevole_charge WHERE idBenevole = '".$id['id']."'";
            $res = $mysqli->query($sql);
            $erreur['correct'] = $sql;

            $sql = "DELETE FROM benevole_dispo WHERE idBenevole = '".$id['id']."'";
            $res = $mysqli->query($sql);
            $erreur['correct'] = $res;
            }

    }
    echo json_encode($erreur);
?>
