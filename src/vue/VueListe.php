<?php
namespace mywishlist\vue;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'vendor/autoload.php';

class VueListe{
    function affichageListe(Request $rq,Response $rs,$args){
        $listes=Liste::select('no', 'user_id', 'titre', 'description', 'expiration', 'token')->where('no','=', $args)->get();
        foreach ($listes as $l){
            if($l->liste()->first()!=null){
                $rs->getBody()->write($l->no.",".$l->user_id.",".$l->titre.",".$l->description.",".$l->expiration.",".$l->token."<br>");
                return $rs;
            } 
    }
    } 
}

