<?php
namespace mywishlist\vue;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \mywishlist\model\Liste as Liste;
require_once 'vendor/autoload.php';
require_once 'src/model/Liste.php';
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
            $listes=Liste::select('no', 'user_id', 'titre', 'description', 'expiration', 'token')->where('no','=', $args)->get();
            foreach ($listes as $l){
                if($l->first()!=null){
                    $rs->getBody()->write($l->no."<br>".$l->user_id."<br>".$l->titre."<br>".$l->description."<br>".$l->expiration."<br>".$l->token."<br>");
                    return $rs;
                } 
            }
        }catch(Exception $e){
            echo $e;
        }
    } 
}

