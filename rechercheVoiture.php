<?php

require_once("./bdd/db_connexion.php");
$connexion = new db_connexion();
$res = $connexion->connexion();
if ($res) {
    $columns = $connexion->get_all_columns_from_table("locations");
    $num = $connexion->get_count_number("idclient", "locations")[0]["COUNT(idclient)"];
    if (array_key_exists("recherche", $_GET)) {
        $client = $connexion->recherche_voiture($_GET["recherche"]);
    }

}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Recherche Voiture</title>
    <link rel="stylesheet" href="./src/style.css"/>
</head>
<body>
<header>
    <div class="header-content">
        <div>
            <h3><a href="index.php" style="color: black;">Voitures</a></h3>
        </div>
        <nav>
            <button id="menu">Menu</button>
        </nav>
    </div>
    <div class="menu-show" id="menu-show">
        <label>Formulaire</label>
        <hr>
        <a href="affichageVoitures.php">Affichage Voiture</a>
        <a href="affichageClients.php">Affichage Clients</a>
        <a href="affichageLocations.php">Affichage Location</a>
        <hr>
        <label>Formulaire</label>
        <hr>
        <a href="formulaireClient.php">Formulaire Client</a>
        <a href="formulaireLocation.php">Formulaire Location</a>
        <a href="formulaireVoiture.php">Formulaire Voiture</a>
        <hr>
        <label>Recherche</label>
        <hr>
        <a href="rechercheClient.php">Recherche Client</a>
        <a href="rechercheVoiture.php">Recherche Voiture</a>
    </div>
</header>
<main>
    <h3>Recherche Voiture Loué</h3>
    <form method="get" action="rechercheVoiture.php">
        <label>Nom du client / Prénom : </label>
        <input type="text" name="recherche">
        <input type="submit" value="Recherche">
    </form>
    <table>
        <thead>
        <tr>
            <?php foreach ($columns as $co) : ?>
                <th scope="col"><?= $co ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($client)) foreach ($client as $c) : ?>
            <tr>
                <?php foreach ($columns as $co) : ?>
                    <th scope="row"><?= $c["$co"] ?></th>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="page">
        <?php
        $p = 0;
        if (array_key_exists("select", $_GET)) {
            $amount = ceil($num / $_GET["select"]);
            while ($p < $amount) {
                echo "<button onclick='Set_Location($p)'>$p</button>";
                $p++;
            }
        }
        ?>
    </div>
</main>
</body>
<script>

    window.onload = function (){
        menu_click();
    }

    var i = 2;

    function menu_click(){
        let menu_button = document.getElementById("menu");
        let menu_show = document.getElementById("menu-show");
        menu_button.addEventListener("click",function (){
            if(i%2!=0){
                menu_show.style.display = "none";
            }else{
                menu_show.style.display = "flex";
            }
            i++;
        })
    }


</script>
</html>

