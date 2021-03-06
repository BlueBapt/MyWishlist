<?php
require 'vendor/autoload.php';

use mywishlist\controller\AffichageItemController;
use mywishlist\controller\CompteController;
use mywishlist\controller\ConnexionController;
use mywishlist\controller\ItemController;
use mywishlist\controller\ListeController;
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
    return ListeController::afficherCreerListe($rq,$rs,$args);
});
$app->post('/creer/liste',function (Request $rq, Response $rs, $args):Response {
    session_start();
    return ListeController::envoyerListe($rq,$rs,$args);
});

$app->get('/item/action',function(Request $rq, Response $rs, $args):Response{
    session_start();
    return ItemController::itemAction($rq, $rs, $args);
});

$app->post('/item/action',function(Request $rq, Response $rs, $args):Response{
    session_start();
    return ItemController::itemAction($rq, $rs, $args);
});
$app->get('/',function (Request $rq, Response $rs, $args):Response {
    session_start();
    return VueAcceuil::afficherFormulaire($rq, $rs, $args);
});
$app->get('/inscription',function (Request $rq, Response $rs, $args):Response {
    session_start();
    return ConnexionController::pageConnexion($rq,$rs,$args);
});

$app->post('/inscription',function (Request $rq, Response $rs, $args):Response {
    session_start();
    return ConnexionController::seConnecter($rq, $rs, $args);
});


$app->get('/liste/{no}[/{token}]',function(Request $rq, Response $rs, $args):Response{
    session_start();
    return ListeController::afficherTout($rq,  $rs, $args);
});

$app->post('/liste/{no}[/{token}]',function(Request $rq, Response $rs, $args):Response{
    session_start();
    return ListeController::posterCommentaire($rq,  $rs, $args);
});

$app->get('/item/{id}',function(Request $rq, Response $rs, $args):Response{
    session_start();
    return VueAfficherItem::affichageItem($rq,$rs,$args);
});

$app->get('/choix/item',function(Request $rq, Response $rs, $args):Response{
    session_start();
    VueHeader::afficherFormulaire($rq,$rs,$args);
    return AffichageItemController::affichageItem($rq,$rs,$args);
});
$app->post('/choix/item',function(Request $rq, Response $rs, $args):Response{
    session_start();
    VueHeader::afficherFormulaire($rq,$rs,$args);
    return AffichageItemController::affichageItem($rq,$rs,$args);
});

$app->get('/reservation',function(Request $rq,Response $rs, $args):Response{
    session_start();
    try{
        return VueReservation::afficherFormulaireReservation($rq,$rs,$args);
    }catch(Exception $e){
        echo $e;
    }
});

$app->get('/compte',function(Request $rq,Response $rs, $args):Response{
    session_start();
    try{
        return CompteController::afficherCompte($rq,$rs,$args);
    }catch(Exception $e){
        echo $e;
    }
});



$app->run();