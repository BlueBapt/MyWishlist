<?php

namespace mywishlist\controller;
require_once 'vendor/autoload.php';

use Exception;
use Illuminate\Database\Capsule\Manager as DB;
use mywishlist\model\Authentification;
use mywishlist\model\Message as Message;
use mywishlist\vue\VueInscription;
use mywishlist\vue\VueHeader;
use mywishlist\vue\VueListe;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ListeController
{
    public static function afficherTout(Request $rq, Response $rs, $args)
    {
        $rs = VueHeader::afficherFormulaire($rq,$rs,$args);
        $rs = VueListe::vueAfficherTout($rq, $rs, $args);
        if (isset($_SESSION["user"])) {
            $rs->getBody()->write(<<<END
                <hr> <br>
                <form method="post">
                    <textarea name="commentaire" id="titre" placeholder="Entrez un commentaire... (140 caracteres max)" required></textarea>
                    <input type="submit" value="Valider">
                </form>
                
                END);
        } else {
            $rs->getBody()->write(<<<END
                <hr> <br>
                    Connectez vous pour ajouter un commentaire!<br>
                
                END);
        }
        return $rs;
    }

    public static function posterCommentaire(Request $rq, Response $rs, $args)
    {
        $db = new DB();
        $db->addConnection(['driver' => 'mysql', 'host' => 'localhost', 'database' => 'mywishlist',
            'username' => 'wishmaster', 'password' => 'TropFort54', 'charset' => 'utf8', 'collation' => 'utf8_unicode_ci',
            'prefix' => '']);
        $db->setAsGlobal();
        $db->bootEloquent();
        if (isset($_POST["commentaire"])) {
            try {
                $nm = new Message();
                $nm->contenu = filter_var($_POST["commentaire"], FILTER_SANITIZE_STRING);
                $nm->psuedo = $_SESSION["user"];
                $nm->no = $args["no"];
                $nm->save();
                unset($_POST["commentaire"]);
            } catch (Exception $e) {
                echo $e;
            }
        }
        return ListeController::afficherTout($rq, $rs, $args);
    }
}