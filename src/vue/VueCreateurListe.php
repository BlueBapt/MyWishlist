<?php

namespace mywishlist\vue;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \mywishlist\model\Liste as Liste;
require_once 'src/conf/ClassLoaderPsr4.php';
require_once 'src/model/Liste.php';
use Illuminate\Database\Capsule\Manager as DB;
class VueCreateurListe
{
    public static function afficherFormulaire(Request $rq, Response $rs, $args):Response{
        $rs->getBody()->write(<<<END
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MyWishList</title>
</head>
<body>
<a href="http://127.0.0.1/mywishlist">Retour à la page d'accueil</a>
END);
        if(isset($_GET["description"]) && isset($_GET["titre"]) && isset($_GET["exp"])){
            $rs->getBody()->write(<<<END
            <div class="reussite" >L'opération est une réussite!</div>
            END);
            $db = new DB();
            $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
                'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
                'prefix'=>''] );
            $db->setAsGlobal();
            $db->bootEloquent();

            try {
                $res = Liste::select("titre")->get();
            }catch(\Exception $e){
                echo $e;
            }
            $i =1;
            foreach ($res as $r) {
                $i++;
            }
            $nl = new Liste();
            $nl->no=$i;
            $nl->user_id=$i;

            $nl->titre=filter_var($_GET["titre"] ,FILTER_SANITIZE_STRING);
            $nl->description=filter_var($_GET["description"] ,FILTER_SANITIZE_STRING);
            $nl->expiration=filter_var($_GET["exp"] ,FILTER_SANITIZE_STRING);
            $nl->token="nosecure".$i;

            if (isset( $_COOKIE[ 'token' ] )){
                $cookie=unserialize($_GET["token"]);
                $cookie[]="nosecure".$i;
                $cookie=serialize($cookie);
                setcookie("token",$cookie,time()+60*60*1,"");
            }else{
                $cookie=serialize(array("nosecure".$i));
                setcookie("token",$cookie,time()+60*60*1,"");
            }

            try {
                $nl->save();
            }catch(\Exception $e){
                echo $e;
            }
        }
        $rs->getBody()->write(<<<END
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