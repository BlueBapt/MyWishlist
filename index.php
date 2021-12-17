<?php
require 'vendor/autoload.php';
use mywishlist\vue\VueAcceuil;
use mywishlist\vue\VueInscription;
use \mywishlist\vue\VueReservation;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \mywishlist\vue\VueCreateurListe as VueCreateurListe;
use \mywishlist\vue\VueAjoutItem as VueAjoutItem;
use \mywishlist\vue\VueListe as VueListe;
use \mywishlist\vue\VueAfficherItem as VueAfficherItem;




$app = new \Slim\App;
$app->get('/creer/liste',function (Request $rq, Response $rs, $args):Response {
    return VueCreateurListe::afficherFormulaire($rq,$rs,$args);
});
$app->get('/ajout/item',function (Request $rq, Response $rs, $args):Response {
    return VueAjoutItem::afficherFormulaire($rq, $rs, $args);
});
$app->get('/',function (Request $rq, Response $rs, $args):Response {
    return VueAcceuil::afficherFormulaire($rq, $rs, $args);
});
$app->get('/inscription',function (Request $rq, Response $rs, $args):Response {
    return VueInscription::afficherFormulaire($rq, $rs, $args);
});


$app->get('/liste/{no}',function(Request $rq, Response $rs, $args):Response{
    try{
        return VueListe::affichageListe($rq,$rs,$args);
    }catch(Exception $e){
        echo $e;
    }
});

$app->get('/item/{id}',function(Request $rq, Response $rs, $args):Response{
    try{
        return VueAfficherItem::affichageItem($rq,$rs,$args);
    }catch(Exception $e){
        echo $e;
    }
});

$app->get('/reservation',function(Request $rq,Response $rs, $args):Response{
    try{
        return VueReservation::etatReservation($rq,$rs,$args);
    }catch(Exception $e){
        echo $e;
    }
});

$app->run();