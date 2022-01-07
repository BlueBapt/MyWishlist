<?php
namespace mywishlist\vue;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \mywishlist\model\Liste as Liste;
use \mywishlist\model\Item as Item;
require_once 'vendor/autoload.php';
require_once 'src/model/Liste.php';
require_once 'src/model/Item.php';
use Illuminate\Database\Capsule\Manager as DB;

$user = "wishmaster";
$mdp = "TropFort54";

class VueListe{


    public static function affichageListe(Request $rq,Response $rs,$args):Response{
        try {
            
            $dsn = 'mysql:host=localhost;dbname=mywishlist';
            $db = new DB();
            $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
                'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
                'prefix'=>''] );
            $db->setAsGlobal();
            $db->bootEloquent();
            if(isset($_GET["commentaire"]) && isset($_GET["titre"]) && isset($_GET["exp"])){

            }

            $listes=Liste::select('no', 'user_id', 'titre', 'description', 'expiration', 'token')->where('no','=', $args)->get();
            foreach ($listes as $l){
                if($l->first()!=null){
                    $rs->getBody()->write($l->no."<br>".$l->user_id."<br>".$l->titre."<br>".$l->description."<br>".$l->expiration."<br>".$l->token."<br>");
                } 
            }
            if(isset($_SESSION["user"])){
                $rs->getBody()->write(<<<END
<hr> <br>
<form>
    <textarea name="commentaire" id="titre" placeholder="Entrez un commentaire... (140 caracteres max)" required></textarea>
    <input type="submit" value="Valider">
</form>

END);
            }else {
                $rs->getBody()->write(<<<END
<hr> <br>
<form>
    Connectez vous pour ajouter un commentaire!
</form>

END);

            }

        }catch(Exception $e){
            echo $e;
        }
        return $rs;
    }
    
    public static function vueAfficherTout(Request $rq, Response $rs, $args){
        try {
            $dsn = 'mysql:host=localhost;dbname=mywishlist';
            $db = new DB();
            $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
                'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
                'prefix'=>''] );
            $db->setAsGlobal();
            $db->bootEloquent();
            $listes=Liste::select('no', 'user_id', 'titre', 'description', 'expiration', 'token')->where('no','=', $args)->get();
            $item = Item::select('id','img')->where('liste_id', '=',$args)->get();
            foreach ($listes as $l){
                if($l->first()!=null){
                    $rs->getBody()->write($l->no."<br>".$l->user_id."<br>".$l->titre."<br>".$l->description."<br>".$l->expiration."<br>".$l->token."<br>");
                    foreach($item as $i){
                        $image = '/img/'.$i->img;
                        echo "<a href='http://localhost/mywishlist/item/$i->id'</a>";
                        echo "<img src='../$image' width='300em'>"."<br>";
                    }
                } 
            }

        } catch(Exception $e){
            echo $e;
        }
        return $rs;
    }
}

