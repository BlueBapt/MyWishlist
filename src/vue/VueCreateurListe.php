<?php

namespace mywishlist\vue;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'vendor/autoload.php';
class VueCreateurListe
{
    public static function afficherFormulaire(Request $rq, Response $rs, $args):Response{
        $rs->getBody()->write("ici on va ajouter une liste de souhait<br>");
        $rs->getBody()->write("les informations sont : titre, description et date d'expiration");
        $rs->getBody()->write(<<<END
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MyWishList</title>
</head>
<body>
    <form class="formulaire">
        <fieldset>
            <legend id="ajt">Création d'une wishlist.</legend>
        <p class="titre">
            <label for="titre">Entrer le titre de cette wishlist : </label>
            <input type="text" name="titre" id="titre" placeholder="Titre" required>
        </p>
        <p class="description">
            <label for="description">Entrer la description : </label>
            <input type="text" name="description" id="descr" placeholder="Description" required>
        </p>
        <p class="exp">
            <label for="exp">Entrer la date d'expiration : </label>
            <input type="date" name="exp" id="exp" required>
        </p>
        <input type="submit" value="Valider">
        </fieldset>
    </form>

    <style>
        body{
        background-color: lightgray;
        background-image: url('7ds.gif');
        background-size: cover;
    }

    form{
        width: 50%;
        grid-column: 2;
        background-color: rgb(22, 31, 41);
        border: 5px ridge white;
        margin-left: 25%;
        height: 205px;
    }

    form > fieldset > p{
        color: white;
        margin-bottom: 20px;
    }

    legend{
        color: white;
    }
    </style>
</body>
</html>

END);

        return $rs;
    }
}