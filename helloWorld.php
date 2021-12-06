<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';
$app = new \Slim\App;
$app->get('/hello/{name}',
    function (Request $rq, Response $rs, $args):Response {
        $name = $args['name'];
        $rs->getBody()->write("Hello, $name");
        return $rs;
    })->setName("test ");

$app->get('/bjr/{name}',
    function (Request $rq, Response $rs, $args):Response {
        $name = $args['name'];
        $rs->getBody()->write("bjr, $name");
        return $rs;
    })->setName("test ");

$app->run();