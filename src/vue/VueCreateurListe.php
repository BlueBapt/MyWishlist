<?php

namespace mywishlist\vue;
require_once 'src/model/Liste.php';
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \mywishlist\model\Liste as Liste;
use Illuminate\Database\Capsule\Manager as DB;
class VueCreateurListe
{
    public static function afficherFormulaire(Request $rq, Response $rs, $args):Response{
        $rs->getBody()->write(<<<END
    <form class="formulaire" method="post">
        <fieldset>
            <legend id="ajt">Création d'une wishlist.</legend>
        <p class="titre">
            <label for="titre">Entrer le titre de cette wishlist : </label>
            <input type="text" name="titre" id="titre" placeholder="Titre" required>
        </p>
        <p class="description">
            <label for="description">Entrer la description : </label>
            <textarea name="description" id="descr" placeholder="Description" required></textarea>
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
        background-size: cover;
    }
    
    .reussite{
        color:white;
        width: 50%;
        background-color: green;
        border: 5px ridge white;
        margin-left: 25%;
        height: 2em;
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

    public static function afficherPasCo(Request $rq, Response $rs, $args):Response{
        $rs->getBody()->write(<<<END
    <h3>Connectez vous pour créer une liste!</h3>

    <style>
        body{
        background-color: lightgray;
        background-size: cover;
    }
    
    .reussite{
        color:white;
        width: 50%;
        background-color: green;
        border: 5px ridge white;
        margin-left: 25%;
        height: 2em;
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