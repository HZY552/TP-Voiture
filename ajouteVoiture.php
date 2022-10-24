<?php

    $imm = $_POST["immatriculation"];
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $cylindree = $_POST['cylindree'];
    $date = $_POST['dateachat'];

    require_once ("./bdd/db_connexion.php");
    $connexion = new db_connexion();
    $connexion_res = $connexion->connexion();
    if ($connexion_res){
        if (!empty($imm) && !empty($marque) && !empty($modele) && !empty($cylindree) && !empty($date)){

            $values = array();
            array_push($values,$imm,$marque,$modele,$cylindree,$date);
            try {
                $res = $connexion->insert_one("voiture",$values);
                echo "Insertion de données: ' " . implode(",", $values) . " '";
            }catch (PDOException $exception){
                echo "ErrorCode: " . $exception->getCode();
            }

        }else{
            echo "les champs sont pas remplis!";
        }

    }else{
        echo "Error BDD";
    }
