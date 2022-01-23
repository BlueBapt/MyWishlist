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
        $url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];
        $sep = explode("/mywishlist", $url);
        $url = $sep[0] . "/mywishlist";

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
        $rs->getBody()->write("<p style='margin-bottom: 3em; color: blue; margin-left: .5em; text-decoration: underline; font-size: large'>Commentaires :</p>");
        foreach ($commentaires as $co) {
            $rs->getBody()->write('<div class="message"><div class="pseudo">' . Utilisateur::select("user_id","psuedo")->where("user_id","=",$args["no"])->get()->first()->psuedo . '</div><div class="contenu" id="contenu"><p class="cont" id="cont">' . $co->contenu . '</p></div></div><br>');
            $rs->getBody()->write(<<<END
                <style>
                .message{
                    display: flex;
                    flex-direction: column;
                    margin-bottom: 2em;
                }
                .pseudo{
                    color: white; 
                    text-decoration: underline;
                    margin-bottom: 1em;
                    margin-left: 1em;
                }
                .contenu{
                    margin-left: 5em;
                    background-color: cornflowerblue;
                    color: white;
                    border-radius: 1em;
                    width: 12.5%;
                    text-align: center;
                }
                .cont{
                    padding: 1em;
                }
                </style>
            END
            );
        }
        return $rs;
    }
}

