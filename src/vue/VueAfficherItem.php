<?php

namespace mywishlist\vue;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'vendor/autoload.php';
header ("Content-type: image/jpeg");

class VueAfficherItem
{
    function affichageItem(Request $rq,Response $rs,$args){
        $item=Item::select('id','liste_id','nom','descr','img','tarif')->where('id','=',$args)->get();
        foreach ($item as $c){
            $image = imagecreatefromjpeg($c->img);
            if($c->item()->first()!=null){
                $rs->getBody()->write($c->id.",".$c->liste_id.",".$c->nom.",".$c->descr.",".$c->tarif."<br>");
                imagejpg($image);
                return $rs;
            }
        }
    }
}