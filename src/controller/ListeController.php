<?php

namespace mywishlist\controller;
require_once 'vendor/autoload.php';

use Exception;
use Illuminate\Container\Util;
use Illuminate\Database\Capsule\Manager as DB;
use mywishlist\model\Authentification;
use mywishlist\model\Liste as Liste;
use mywishlist\model\Message as Message;
use mywishlist\model\Utilisateur;
use mywishlist\vue\VueCreateurListe;
use mywishlist\vue\VueInscription;
use mywishlist\vue\VueHeader;
use mywishlist\vue\VueListe;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ListeController
{
    public static function afficherTout(Request $rq, Response $rs, $args)
    {
        $db = new DB();
        $db->addConnection(['driver' => 'mysql', 'host' => 'localhost', 'database' => 'mywishlist',
            'username' => 'wishmaster', 'password' => 'TropFort54', 'charset' => 'utf8', 'collation' => 'utf8_unicode_ci',
            'prefix' => '']);
        $db->setAsGlobal();
        $db->bootEloquent();

        $rs = VueHeader::afficherFormulaire($rq, $rs, $args);
        try{
            $elem = Liste::select("token","no","user_id")->where("no","=",$args["no"])->get()->first();
            $bonToken = $elem->token;
            $userID= $elem->user_id;
        }catch(Exception $e){
            $rs->getBody()->write($e);
            $bonToken=null;
        }

        if($bonToken===$args["token"]) {
            if($userID===$_SESSION["id"] || $_SESSION["rights"]>Authentification::$USER) {
                $rs->getBody()->write(<<<END
            <form method="post">
                 <input type="submit" name="effacer" value="Effacer cette liste">
            </form>
            
END
                );
            }
            $rs = VueListe::vueAfficherTout($rq, $rs, $args);
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
        }else{
            $rs->getBody()->write("<h1> Erreur : la liste n'existe pas ou le token n'est pas bon </h1>");
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

    public static function afficherCreerListe(Request $rq, Response $rs, $args): Response
    {
        $rs = VueHeader::afficherFormulaire($rq,$rs,$args);
        if(isset($_SESSION["user"])){
            $rs = VueCreateurListe::afficherFormulaire($rq,$rs,$args);
        }else{
            $rs = VueCreateurListe::afficherPasCo($rq,$rs,$args);
        }

        return $rs;
    }

    public static function envoyerListe(Request $rq, Response $rs, $args){
        $rs=ListeController::afficherCreerListe($rq,$rs,$args);
        if(isset($_POST["description"]) && isset($_POST["titre"]) && isset($_POST["exp"])){
            $rs->getBody()->write(<<<END
            <div class="reussite" >L'opération est une réussite!</div>
            END);
            $db = new DB();
            $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
                'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
                'prefix'=>''] );
            $db->setAsGlobal();
            $db->bootEloquent();

            $id_user = Utilisateur::select("id_user, psuedo");

            $res = Liste::select("titre")->get();
            $i =1;
            foreach ($res as $r) {
                $i++;
            }
            $nl = new Liste();
            $nl->no=$i;
            $nl->user_id=$_SESSION["id"];

            $nl->titre=filter_var($_POST["titre"] ,FILTER_SANITIZE_STRING);
            $nl->description=filter_var($_POST["description"] ,FILTER_SANITIZE_STRING);
            $nl->expiration=filter_var($_POST["exp"] ,FILTER_SANITIZE_STRING);
            $nl->token="nosecure".$_SESSION["id"];

            try {
                $nl->save();
            }catch(Exception $e){
                echo $e;
            }
        }
        return $rs;
    }
}