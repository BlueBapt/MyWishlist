<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \mywishlist\vue\VueCreateurListe as VueCreateurListe;
use \mywishlist\vue\VueAjoutItem as VueAjoutItem;
require 'vendor/autoload.php';
require 'src/vue/VueCreateurListe.php';
require 'src/vue/VueAjoutItem.php';

$app = new \Slim\App;
$app->get('/creer/liste',function (Request $rq, Response $rs, $args):Response {
    return VueCreateurListe::afficherFormulaire($rq,$rs,$args);
});
$app->get('/ajout/item',function (Request $rq, Response $rs, $args):Response {
    return VueAjoutItem::afficherFormulaire($rq, $rs, $args);
});

$app->run();