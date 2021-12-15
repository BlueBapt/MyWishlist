<?php

namespace mywishlist\vue;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use mywishlist\model\Item as Item;
require_once 'vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as DB;


class VueAfficherItem
{
    public static function affichageItem(Request $rq,Response $rs,$args):Response{
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();
        $item = Item::select('id', 'liste_id', 'nom', 'descr', 'img', 'tarif')->where('id', '=', $args)->get();
        foreach ($item as $c) {
            if ($c->first() != null) {
                $rs->getBody()->write($c->id . "," . $c->liste_id . "," . $c->nom . "," . $c->descr . "," . $c->tarif . "<br>");
                $image = '/img/'.$c->img;
                echo "<br><img src='../$image' alt='image'>";
            }
        }
        return $rs;
    }
}