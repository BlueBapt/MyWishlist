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
        <p class="exp">
            <label for="mdp">Entrer un mot de passe : </label>
            <input type="text" name="mdp" id="mdp" minlength="4" required>
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
        border: 0.2em ridge white;
        margin-left: 25%;
        height: 2em;
    }

    form{
        width: 50%;
        grid-column: 2;
        background-color: rgb(22, 31, 41);
        border: 0.2em ridge white;
        margin-left: 25%;
        height: 15em;
        font-size: 1.1em;
    }

    form > fieldset > p{
        color: white;
        margin-bottom: 1.2em;
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
    <h3 class="erreur">Connectez vous pour créer une liste!</h3>

    <style>
        body{
        text-align: center ;
        font-size: 1.1em;
    }
    
    .erreur{
        font-size: 1.3em;
        color:white;
    }
    
    
    </style>
</body>
</html>

END);

        return $rs;
    }

    public static function partagerListe(Request $rq, Response $rs, $args):Response{
        $rs->getBody()->write(<<<END
        <h3 class="Partage">Partager une liste !</h3>
        END);  
        $l = Liste::where("token", "=", $token)->first();
        if (isset($_SESSION['session']['user_id']) && $l->user_id == -1) {
            $l->user_id = $_SESSION['session']['user_id'];
            $l->save();
            $NouvelleURL = $args->urlFor('route_get_Liste');
            $rs->getBody()->write($NouvelleURL);
        }
        return $rs;
    }
}