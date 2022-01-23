<?php

namespace mywishlist\controller;
require_once 'vendor/autoload.php';

use Exception;
use Illuminate\Container\Util;
use Illuminate\Database\Capsule\Manager as DB;
use mywishlist\model\Authentification;
use mywishlist\model\Liste as Liste;
use mywishlist\model\Message as Message;
use mywishlist\model\Utilisateur;
use mywishlist\vue\VueCreateurListe;
use mywishlist\vue\VueInscription;
use mywishlist\vue\VueHeader;
use mywishlist\vue\VueListe;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CompteController
{
    public static function afficherCompte(Request $rq, Response $rs, $args)
    {


    }
}