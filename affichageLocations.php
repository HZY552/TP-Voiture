<?php

require_once("./bdd/db_connexion.php");
$connexion = new db_connexion();
$res = $connexion->connexion();
if ($res) {

    $columns = $connexion->get_all_columns_from_table("locations");
    $num = $connexion->get_count_number("idlocation", "locations")[0]["COUNT(idlocation)"];
    if (array_key_exists("page", $_GET) && array_key_exists("select", $_GET)) {
        $s = $_GET["page"] * $_GET["select"];
        $client = $connexion->afficher("locations", $s, $_GET["select"]);
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Locations</title>
    <link rel="stylesheet" href="./src/style.css"/>
</head>
<script>
    window.onload = function () {

        menu_click();
        let select = getQueryVariable("select");
        let page = getQueryVariable("page");

        if (!select && !page) {
            window.location.href = "affichageLocations.php?select=3&page=0";
        }

        if (!page && select) {
            window.location.href = "affichageLocations.php?select=" + select + "&page=0";
        }
        let optionsID = select;
        let select_options = document.getElementById("select").options;

        for (let i = 0; i < select_options.length; i++) {

            if (select_options[i].id == optionsID) {
                select_options[i].selected = true;
            }
        }
    }

    function getQueryVariable(variable) {
        let query = window.location.search.substring(1);
        let vars = query.split("&");
        for (let i = 0; i < vars.length; i++) {
            let pair = vars[i].split("=");
            if (pair[0] == variable) {
                return pair[1];
            }
        }
        return (false);
    }

    function Set_Location(page) {
        let select = getQueryVariable("select");
        window.location.href = "affichageLocations.php?select=" + select + "&page=" + page;
    }

    function home_page() {
        let select = getQueryVariable("select");
        window.location.href = "affichageLocations.php?select=" + select + "&page=" + 0;
    }

    function next_page(max) {
        let select = getQueryVariable("select");
        let page = parseInt(getQueryVariable("page"));

        let page_next = page + 1;
        if (page_next <= max) {
            window.location.href = "affichageLocations.php?select=" + select + "&page=" + page_next;
        }

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
    <h3>Locations</h3>
    <form method="get" action="affichageLocations.php">
        <select name="select" id="select" class="select-form">
            <?php $i = 3;
            while ($i < 11): ?>
                <option id="<?= $i ?>">
                    <?php
                    echo $i;
                    ?>
                </option>
                <?php $i++; endwhile; ?>
        </select>
        <input type="submit" value="Change">
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
        <button onclick="home_page()">Précedent</button>
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
        <button onclick="next_page(<?= $p - 1 ?>)">Suivant</button>
    </div>
</main>
</body>

</html>

