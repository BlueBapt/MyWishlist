<?php
require 'vendor/autoload.php';

use mywishlist\model\Authentification as Authentification;
use mywishlist\vue\VueAcceuil;
use mywishlist\vue\VueHeader;
use mywishlist\vue\VueImageItem;
use mywishlist\vue\VueInscription;
use mywishlist\vue\VueItemSup;
use \mywishlist\vue\VueReservation;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \mywishlist\vue\VueCreateurListe as VueCreateurListe;
use \mywishlist\vue\VueAjoutItem as VueAjoutItem;
use \mywishlist\vue\VueListe as VueListe;
use \mywishlist\vue\VueAfficherItem as VueAfficherItem;




$app = new \Slim\App;
$app->get('/creer/liste',function (Request $rq, Response $rs, $args):Response {
    session_start();
    return VueCreateurListe::afficherFormulaire($rq,$rs,$args);
});
$app->get('/ajout/item',function (Request $rq, Response $rs, $args):Response {
    session_start();
    return VueAjoutItem::afficherFormulaire($rq, $rs, $args);
});
$app->get('/modifie/item',function (Request $rq, Response $rs, $args):Response {
    session_start();
    try {
        VueHeader::afficherFormulaire($rq, $rs, $args);
        return VueImageItem::afficherFormulaire($rq, $rs, $args);
    }catch (\Throwable $e){
        echo $e;
    }
});
$app->post('/modifie/item',function (Request $rq, Response $rs, $args):Response {
    try {
        session_start();
        VueHeader::afficherFormulaire($rq, $rs, $args);
        return VueImageItem::afficherFormulaire($rq, $rs, $args);
    }catch (\Throwable $e){
        echo $e;
    }
    return $rs;
});
$app->get('/sup/item',function (Request $rq, Response $rs, $args):Response {
    try {
        session_start();
        VueHeader::afficherFormulaire($rq, $rs, $args);
        VueItemSup::afficherFormulaire($rq, $rs, $args);
    }catch (\Throwable $e){
        echo $e;
    }
    return $rs;
});
$app->post('/sup/item',function (Request $rq, Response $rs, $args):Response {
    try {
        session_start();
        VueHeader::afficherFormulaire($rq, $rs, $args);
        VueItemSup::afficherFormulaire($rq, $rs, $args);
    }catch (\Throwable $e){
        echo $e;
    }
    return $rs;
});
/**
$app->post('/modifie/item',function (Request $rq, Response $rs, $args):Response {
    VueHeader::afficherFormulaire($rq, $rs, $args);
    return VueImageItem::afficherFormulaire($rq, $rs, $args);
});
 */
$app->get('/',function (Request $rq, Response $rs, $args):Response {
    session_start();
    return VueAcceuil::afficherFormulaire($rq, $rs, $args);
});
$app->get('/inscription',function (Request $rq, Response $rs, $args):Response {
    session_start();
    return VueInscription::afficherFormulaire($rq, $rs, $args);
});

$app->post('/inscription',function (Request $rq, Response $rs, $args):Response {
    session_start();
    return VueInscription::afficherFormulaire($rq, $rs, $args);
});


$app->get('/liste/{no}',function(Request $rq, Response $rs, $args):Response{
    session_start();
    try{
        //return VueListe::affichageListe($rq,$rs,$args);
        return VueListe::vueAfficherTout($rq,$rs,$args);
    }catch(Exception $e){
        echo $e;
    }
});

$app->post('/liste/{no}',function(Request $rq, Response $rs, $args):Response{
    session_start();
    try{
        //return VueListe::affichageListe($rq,$rs,$args);
        return VueListe::vueAfficherTout($rq,$rs,$args);
    }catch(Exception $e){
        echo $e;
    }
});

$app->get('/item/{id}',function(Request $rq, Response $rs, $args):Response{
    session_start();
    try{
        return VueAfficherItem::affichageItem($rq,$rs,$args);
    }catch(Exception $e){
        echo $e;
    }
});

$app->get('/reservation',function(Request $rq,Response $rs, $args):Response{
    session_start();
    try{
        return VueReservation::etatReservation($rq,$rs,$args);
    }catch(Exception $e){
        echo $e;
    }
});

$app->get('/cheat',function(Request $rq,Response $rs, $args):Response{
    session_start();
    try{
        Authentification::creerUtilisateur("Jamy","juste","oui",10);
        Authentification::authentification("Jamy","juste");
        $rs->getBody()->write("c bon");
    }catch(Exception $e){
        echo $e;
    }
    return $rs;
});

$app->get('/deco',function(Request $rq,Response $rs, $args):Response{
    session_start();
    try{
        unset($_SESSION["user"]);
        $rs->getBody()->write("c bon");
    }catch(Exception $e){
        echo $e;
    }
    return $rs;
});

$app->run();