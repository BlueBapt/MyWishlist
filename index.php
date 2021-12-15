<?php

use mywishlist\vue\VueAcceuil;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \mywishlist\vue\VueCreateurListe as VueCreateurListe;
use \mywishlist\vue\VueAjoutItem as VueAjoutItem;
use \mywishlist\vue\VueListe as VueListe;
use \mywishlist\vue\VueAfficherItem as VueAfficherItem;
require 'vendor/autoload.php';
require 'src/vue/VueCreateurListe.php';
require 'src/vue/VueAjoutItem.php';
require 'src/vue/VueListe.php';
require 'src/vue/VueAfficherItem.php';
require_once 'src/vue/VueAcceuil.php';

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


$app->get('/liste/{no}',function(Request $rq, Response $rs, $args):Response{
    try{
        return VueListe::affichageListe($rq,$rs,$args);
    }catch(Exception $e){
        echo $e;
    }
});

$app->get('/item/{id}',function(Request $rq, Response $rs, $args):Response{
    try{
        echo 1;
        return VueAfficherItem::affichageItem($rq,$rs,$args);
    }catch(Exception $e){
        echo $e;
    }
});

$app->run();