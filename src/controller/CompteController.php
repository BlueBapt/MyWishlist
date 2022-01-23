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
use mywishlist\vue\VueCompte;
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
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'root','password'=>'','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();


        if(!isset($_SESSION["id"])){
            $rs=VueHeader::afficherFormulaire($rq,$rs,$args);
            $rs->getBody()->write(<<<END
            <h3>Connectez vous pour acceder à votre compte!</h3>
END);
            return $rs;
        }

        $rs=VueCompte::afficherCompte($rq,$rs,$args);
        return $rs;
    }
}