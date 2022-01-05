<?php

namespace mywishlist\vue;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \mywishlist\model\Reservation as Reservation;
require_once 'vendor/autoload.php';
require_once 'src/model/Liste.php';
use Illuminate\Database\Capsule\Manager as DB;

$user = "wishmaster";
$mdp = "TropFort54";

class VueReservation{

    public static function etatReservation(Request $rq, Response $rs, $args):Response{
        setcookie("reservation","2 Heures", time() + 3600 * 2,"vue");
        $track_user_code = $_COOKIE['reservation'];
       
        $rs->getBody()->write(<<<END
            Attente de la reservation<br>
            Temps restant : $track_user_code <br>
        END);
       
        if($track_user_code < 1){
            $rs->getBody()->write(<<<END
                Nom du participant : Nom Utilisateur<br>
                Message    
            
            END);
        }
    return $rs;
    }


}