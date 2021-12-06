<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \mywishlist\vue\VueCreateurListe as VueCreateurListe;
require 'vendor/autoload.php';
require 'src/vue/VueCreateurListe.php';

$app = new \Slim\App;
$app->get('/creer',function (Request $rq, Response $rs, $args):Response {
    return VueCreateurListe::afficherFormulaire($rq,$rs,$args);
});

$app->run();