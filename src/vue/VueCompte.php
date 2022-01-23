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
        $url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];
        $sep = explode("/mywishlist", $url);
        $url = $sep[0] . "/mywishlist";

        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'root','password'=>'','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();

        $rs=VueHeader::afficherFormulaire($rq,$rs,$args);

        $util= Utilisateur::select("psuedo","nom","prenom","user_id")->where("user_id","=",$_SESSION["id"])->get()->first();
        $rs->getBody()->write("<tout>");
        $rs->getBody()->write("<h3 style='margin-left: 12.5%'>".$util->psuedo."</h3><br>");

        $listes =Liste::select("no","user_id","titre","token","estPublique")->where("user_id","=",$_SESSION["id"])->get();
        $rs->getBody()->write("<div class='listes'>");
        $titre = null;
        foreach($listes as $l){
            $titre = "<div class='elem'>"."<p>".$l->titre."</p>";
            if($l->estPublique!=true){
                $titre = $titre . "<p><span style='color: gray'>&ensp</span>Cete liste n'est pas publique</p>";
            }else{
                $titre = $titre . "<p><span style='color: gray'>&ensp</span>Cete liste est publique</p>";
            }
            $titre = $titre . "<span style='color: gray; text-decoration: none'>&ensp</span><a href='$url/liste/".$l->no."/".$l->token."' style='color: white; margin: 0'>Lien de modification</a></div>";
        }
        $rs->getBody()->write("$titre </div>");
        $rs->getBody()->write("</tout>");
        $rs->getBody()->write(<<<END
        <style>
        .listes{
            display:flex;
            flex-direction: column;
            width: 75%;
            margin-left: 12.5%;
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