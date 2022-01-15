<?php

namespace mywishlist\controller;
require_once 'vendor/autoload.php';

use Exception;
use mywishlist\model\Authentification;
use mywishlist\vue\VueInscription;
use mywishlist\vue\VueHeader;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ConnexionController
{
    public static function pageConnexion(Request $rq, Response $rs, $args)
    {
        $rs = VueHeader::afficherFormulaire($rq, $rs, $args);
        return VueInscription::afficherFormulaire($rq, $rs, $args);
    }

    public static function seConnecter(Request $rq, Response $rs, $args)
    {
        $connecte=false;
        if (isset($_POST["mail"])) {
            try {
                Authentification::creerUtilisateur($_POST["login"], $_POST["mdp"], $_POST["mail"], 1);
                Authentification::authentification($_POST["login"], $_POST["mdp"]);
                $connecte=true;
            } catch (Exception $e) {
                $connecte=false;
            }
        } else if (isset($_POST["loginCO"])) {
            try {
                Authentification::authentification($_POST["loginCO"], $_POST["mdpCO"]);
                $connecte=true;
            } catch (Exception $e) {
                $connecte=false;
            }
        }


        $rs = VueHeader::afficherFormulaire($rq, $rs, $args);
        if(!$connecte){
            $rs->getBody()->write(<<<END
            <html>
                <h3>Identifiant incorrect ou mot de passe erroné</h3>
            </html>
END);
        }else{
            $rs->getBody()->write(<<<END
            <html>
                <h3>Connecté!</h3>
            </html>
END);
        }
        $rs = VueInscription::afficherFormulaire($rq, $rs, $args);
        return $rs;


    }
}