<?php

namespace mywishlist\vue;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \mywishlist\model\Item as Item;
require_once 'vendor/autoload.php';
require_once 'src/model/Item.php';
use Illuminate\Database\Capsule\Manager as DB;


class VueAfficherItem
{
    public static function affichageItem(Request $rq,Response $rs,$args):Response{
        try {
            echo "1";
            $db = new DB();
            $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
                'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
                'prefix'=>''] );
            $db->setAsGlobal();
            $db->bootEloquent();
            echo "2";
            $item = Item::select('id', 'liste_id', 'nom', 'descr', 'img', 'tarif')->where('id', '=', $args)->get();
            echo "3";
            foreach ($item as $c) {
                if ($c->first() != null) {
                    $rs->getBody()->write($c->id . "," . $c->liste_id . "," . $c->nom . "," . $c->descr . "," . $c->tarif ."<img src='$c->img'>". "<br>");
                    echo"5";

                    echo"6";
                    return $rs;
                }
            }
            echo "4";
        }catch(\Exception $e){
            echo $e;
        }
    }
}