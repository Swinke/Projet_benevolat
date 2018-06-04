<?php
    $erreur = array();
    if($_POST) {
        /**foreach($_POST as $name => $value) {
            if($name != "montant") {
                if($value == "")
                    $erreur[$name] = "true";
            }
        }**/
        if(!$erreur){
            if(!array_key_exists('permis',$_POST))
                $_POST['permis'] ="";
            if(!array_key_exists('vehicule',$_POST))
                $_POST['vehicule'] ="";
            if(!array_key_exists('3h',$_POST))
                $_POST['3h'] ="";
            if(!array_key_exists('moinsdeux',$_POST))
                $_POST['moinsdeux'] ="";
            if($_POST['date_ins'] == "année/mois/jour")
                $_POST['date_ins'] = date("Y-m-d");
            if($_POST['date'] == "année/mois/jour")
                $_POST['date'] = '';

            $mysqli = new mysqli("localhost","root","","testbenevolat");

            $sql = "SELECT nom, prenom FROM benevole WHERE nom='".$_POST['nom']."' AND prenom= '".$_POST['prenom']."' OR idBenevole = ".$_POST['idB'];
            $res = $mysqli->query($sql)->fetch_assoc();
            if($res) {
                $erreur['exist'] = 'true';
            }
            else {
                if($_POST['type_contrat'] == "autre") {
                    $sql = "INSERT INTO benevole (idBenevole, nom, prenom, sexe, tel, date, courriel, revenu, engagement, integration,type_benevole)"
                            ." VALUES ('".$_POST['idB']."', '".$_POST['nom']."', '".$_POST['prenom']."', '".$_POST['sexe']."',"
                            ."'".$_POST['tel']."', '".$_POST['date']."', '".$_POST['courriel']."', '".$_POST['revenu']."',"
                            ."'','','".$_POST['type_contrat']."')";
                } else if($_POST['type_contrat'] == "benevole" || $_POST['type_contrat'] == "membre engage") { 
                    $sql = "INSERT INTO benevole (idBenevole, nom, prenom, sexe, tel, date, courriel, revenu, engagement, integration,type_benevole)"
                            ." VALUES ('".$_POST['idB']."', '".$_POST['nom']."', '".$_POST['prenom']."', '".$_POST['sexe']."',"
                            ."'".$_POST['tel']."', '".$_POST['date']."', '".$_POST['courriel']."', '".$_POST['revenu']."',"
                            ."'".$_POST['engagement']."','".$_POST['integration']."','".$_POST['type_contrat']."')";
                }
                else {
                    $sql = "INSERT INTO benevole (idBenevole, nom, prenom, sexe, tel, date, courriel, revenu, engagement, integration,type_benevole)"
                            ." VALUES ('".$_POST['idB']."', '".$_POST['nom']."', '".$_POST['prenom']."', '".$_POST['sexe']."',"
                            ."'".$_POST['tel']."', '".$_POST['date']."', '".$_POST['courriel']."', '".$_POST['revenu']."',"
                            ."'','','".$_POST['type_contrat']."')";
                }

                $res = $mysqli->query($sql);
                $erreur['correct'] = $res;
                if($res) {
                    if($_POST['type_contrat'] == "autre") {
                        $sql = "INSERT INTO dossier_benevole (idB, date_ins, app, rue, ville, cp, civique, nationalite, langue, logement, menage, source_revenu, occupation, statut, permis, vehicule,deuxans,troisheure,scolaire,reference)"
                            ." VALUES (".$_POST['idB'].",'".$_POST['date_ins']."','".$_POST['app']."', '".$_POST['rue']."','".$_POST['ville']."','".$_POST['cp']."', ".$_POST['civique'].", '',"
                            ."'','','','','','','','','','','','')";
                    } else if($_POST['type_contrat'] == "benevole") {
                        $sql = "INSERT INTO dossier_benevole (idB, date_ins, app, rue, ville, cp, civique, nationalite, langue, logement, menage, source_revenu, occupation, statut, permis, vehicule,deuxans,troisheure,scolaire,reference)"
                            ." VALUES (".$_POST['idB'].",'".$_POST['date_ins']."','".$_POST['app']."', '".$_POST['rue']."','".$_POST['ville']."','".$_POST['cp']."', ".$_POST['civique'].", '',"
                            ."'".$_POST['langue']."', '', '',"
                            ."'', '','', '', '',"
                            ."'".$_POST['moinsdeux']."','".$_POST['3h']."','','')";
                    
                    } else {
                        $sql = "INSERT INTO dossier_benevole (idB, date_ins, app, rue, ville, cp, civique, nationalite, langue, logement, menage, source_revenu, occupation, statut, permis, vehicule,deuxans,troisheure,scolaire,reference)"
                            ." VALUES (".$_POST['idB'].",'".$_POST['date_ins']."','".$_POST['app']."', '".$_POST['rue']."','".$_POST['ville']."','".$_POST['cp']."', ".$_POST['civique'].", '".$_POST['nationalite']."',"
                            ."'".$_POST['langue']."', '".$_POST['logement']."', '".$_POST['menage']."',"
                            ."'".$_POST['source_revenu']."', '".$_POST['occupation']."','".$_POST['statut']."', '".$_POST['permis']."', '".$_POST['vehicule']."',"
                            ."'".$_POST['moinsdeux']."','".$_POST['3h']."','".$_POST['niveau_sco']."','".$_POST['referer']."')";
                    }
                    $erreur[] = $sql;
                    $res = $mysqli->query($sql);
                    $erreur['correct_d'] = $res;

                    if(!($_POST['type_contrat'] == "autre")) {
                        $sql = "INSERT INTO benevole_persurg (idB, nom, prenom, numero)"
                                ."VALUES (".$_POST['idB'].",'".$_POST['nom_urg']."','".$_POST['prenom_urg']."','".$_POST['tel_urg']."')";

                        $res = $mysqli->query($sql);
                        $erreur['correct_urg'] = $res;

                        $sql = "INSERT INTO benevole_rdv (idB, date, poste)"
                            ."VALUES (".$_POST['idB'].",'".$_POST['date_rdv']."','".$_POST['poste']."')";

                        $res = $mysqli->query($sql);
                        $erreur['correct_urg'] = $res;
                    }
                }
            }
        }
    }
    
    echo json_encode($erreur);
?>
