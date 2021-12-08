<?php

namespace mywishlist\vue;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'vendor/autoload.php';

class VueAjoutItem
{
    public static function afficherFormulaire(Request $rq, Response $rs, $args):Response{
        $rs->getBody()->write("ici on va ajouter un item dans la liste de souhait<br>");
        $rs->getBody()->write("les informations sont : description, image et tarif");
        return $rs;
    }
}