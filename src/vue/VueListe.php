<?php
namespace mywishlist\vue;
require_once 'vendor/autoload.php';

use Exception;
use mywishlist\model\Utilisateur;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \mywishlist\model\Liste as Liste;
use \mywishlist\model\Item as Item;
use \mywishlist\model\Message as Message;

use Illuminate\Database\Capsule\Manager as DB;

class VueListe{
    
    public static function vueAfficherTout(Request $rq, Response $rs, $args, bool $token){
        $db = new DB();
        $db->addConnection(['driver' => 'mysql', 'host' => 'localhost', 'database' => 'mywishlist',
            'username' => 'wishmaster', 'password' => 'TropFort54', 'charset' => 'utf8', 'collation' => 'utf8_unicode_ci',
            'prefix' => '']);
        $db->setAsGlobal();
        $db->bootEloquent();


        $listes = Liste::select('no', 'user_id', 'titre', 'description', 'expiration', 'token')->where('no', '=', $args["no"])->get();
        $item = Item::select('id', 'img')->where('liste_id', '=', $args["no"])->get();
        foreach ($listes as $l) {
            if ($l->first() != null) {
                $rs->getBody()->write("<h2>". $l->titre . "</h2><br>" . $l->description . "<br>Date d'expiration : <strong>" . $l->expiration . "</strong><br><br>");
                $url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];
                $sep = explode("/mywishlist", $url);
                $url = $sep[0] . "/mywishlist";
                foreach ($item as $i) {
                    $_SESSION["idItem"]="oui";
                    $lien = $url."/item/".$i->id;
                    $rs->getBody()->write(<<<END
                <iframe src="$lien"></iframe>
                <style>
                    iframe{
                        width: 50em;
                        height: 30em;
                        border: none;
                    }
                </style>
            END);
                }
            }
        }
        $commentaires = Message::select('no', "user_id", "idmessage", "contenu")->where("no", "=", $args["no"])->get();
        foreach ($commentaires as $co) {
            $rs->getBody()->write('<div class="message"><div class="psuedo">' . Utilisateur::select("user_id","psuedo")->where("user_id","=",$args["no"])->get()->first()->psuedo . '</div><div class="contenu">' . $co->contenu . '</div></div><br>');
        }
        return $rs;
    }
}

