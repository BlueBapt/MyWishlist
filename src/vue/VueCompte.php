<?php

namespace mywishlist\vue;

use Illuminate\Database\Capsule\Manager as DB;
use mywishlist\model\Liste;
use mywishlist\model\Utilisateur;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VueCompte
{
    public static function afficherCompte(Request $rq, Response $rs, $args):Response
    {
        $db = new DB();
        $db->addConnection(['driver' => 'mysql', 'host' => 'localhost', 'database' => 'mywishlist',
            'username' => 'wishmaster', 'password' => 'TropFort54', 'charset' => 'utf8', 'collation' => 'utf8_unicode_ci',
            'prefix' => '']);
        $db->setAsGlobal();
        $db->bootEloquent();

        $rs=VueHeader::afficherFormulaire($rq,$rs,$args);

        $util= Utilisateur::select("psuedo","nom","prenom","user_id")->where("user_id","=",$_SESSION["id"])->get()->first();
        $rs->getBody()->write("<tout>");
        $rs->getBody()->write("<h3>".$util->psuedo."</h3><br>");

        $rs->getBody()->write("<form method='post'>")."<br>";
        if($util->nom!=null){
            $rs->getBody()->write("Nom : ".$util->nom)."<br>";
        }else{
            $rs->getBody()->write("Nom : <input type='text' name='nom' id='nom' required><br>");
        }

        if($util->prenom!=null){
            $rs->getBody()->write("Prenom : ".$util->prenom)."<br>";
        }else{
            $rs->getBody()->write("Prenom : <input type='text' name='prenom' id='prenom' required><br>");
        }
        $rs->getBody()->write("</form>")."<br>";

        $listes =Liste::select("no","user_id","titre","token","estPublique")->where("user_id","=",$_SESSION["id"])->get();
        $rs->getBody()->write("<div class='listes'>");
        foreach($listes as $l){
            $rs->getBody()->write("<div class='elem'>"."<nom>".$l->titre."</nom>");
            if($l->estPublique!=true){
                $rs->getBody()->write("<div>Cete liste n'est pas publique</div>");
            }else{
                $rs->getBody()->write("<div>Cete liste est publique</div>");
            }
            $rs->getBody()->write("<a href='http://127.0.0.1/mywishlist/liste/s".$l->no."/".$l->token."'>Lien de modification</a></div>");
        }
        $rs->getBody()->write("</div>");
        $rs->getBody()->write("</tout>");
        $rs->getBody()->write(<<<END
        <style>
        .listes{
            display:flex;
            flex-direction: column;
        }
        .elem{
            display:flex;
            border-style:solid;
        }
        tout{
            font-size: 1.5em;
        }
    </style>
END
);


        return $rs;
    }
}