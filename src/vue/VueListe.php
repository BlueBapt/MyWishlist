<?php
namespace mywishlist\vue;
require_once 'vendor/autoload.php';

use Exception;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \mywishlist\model\Liste as Liste;
use \mywishlist\model\Item as Item;
use \mywishlist\model\Message as Message;

use Illuminate\Database\Capsule\Manager as DB;

$user = "wishmaster";
$mdp = "TropFort54";

class VueListe{
    
    public static function vueAfficherTout(Request $rq, Response $rs, $args)
    {
        try {
            $dsn = 'mysql:host=localhost;dbname=mywishlist';
            $db = new DB();
            $db->addConnection(['driver' => 'mysql', 'host' => 'localhost', 'database' => 'mywishlist',
                'username' => 'wishmaster', 'password' => 'TropFort54', 'charset' => 'utf8', 'collation' => 'utf8_unicode_ci',
                'prefix' => '']);
            $db->setAsGlobal();
            $db->bootEloquent();

            if(isset($_POST["commentaire"]) ){
                try {
                    $nm = new Message();
                    $nm->contenu=filter_var($_POST["commentaire"] ,FILTER_SANITIZE_STRING);
                    $nm->psuedo=$_SESSION["user"];
                    $nm->no=$args["no"];
                    $nm->save();
                }catch(Exception $e){
                    echo $e;
                }

            }


            $listes = Liste::select('no', 'user_id', 'titre', 'description', 'expiration', 'token')->where('no', '=', $args)->get();
            $item = Item::select('id', 'img')->where('liste_id', '=', $args)->get();
            foreach ($listes as $l) {
                if ($l->first() != null) {
                    $rs->getBody()->write($l->no . "<br>" . $l->user_id . "<br>" . $l->titre . "<br>" . $l->description . "<br>" . $l->expiration . "<br>" . $l->token . "<br>");
                    foreach ($item as $i) {
                        $image = '/img/' . $i->img;
                        $rs->getBody()->write("<a href='http://localhost/mywishlist/item/$i->id'>");
                        $rs->getBody()->write("<img src='../$image' width='300em'>" . "</a><br>");
                    }
                }
            }

            try {
                $commentaires = Message::select('no', "psuedo", "idmessage", "contenu")->where("no", "=", $args)->get();
                foreach ($commentaires as $co) {
                    $rs->getBody()->write('<div class="message"><div class="psuedo">' . $co->psuedo . '</div><div class="contenu">' . $co->contenu . '</div></div><br>');
                }
            }catch(Exception $e){
                echo $e;
            }


            if (isset($_SESSION["user"])) {
                $rs->getBody()->write(<<<END
                <hr> <br>
                <form method="post">
                    <textarea name="commentaire" id="titre" placeholder="Entrez un commentaire... (140 caracteres max)" required></textarea>
                    <input type="submit" value="Valider">
                </form>
                
                END
                );
            } else {
                $rs->getBody()->write(<<<END
                <hr> <br>
                    Connectez vous pour ajouter un commentaire!<br>
                
                END
                );
            }
            return $rs;
        }catch (Exception $e) {
            echo $e;
        }
    }
}

