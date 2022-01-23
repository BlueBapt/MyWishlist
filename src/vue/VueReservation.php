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
        setcookie("reserv","2 Heures", time() + 3600 * 2,"vue");
        $track_user_code = $_COOKIE['reserv'];
       
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

    public static function afficherFormulaireReservation() : string {
        if (isset($_COOKIE['pseudo'])) {
            $p=$_COOKIE['pseudo'];
        }
        else {
            $p="";
        }
        $formulaire = 
            "<form action=\"\" method=\"post\">
                <h2>Reserver un Item</h2>
                           <div class=\"formulaire\">
                                <input style=\"text-align:center\" type=\"text\" name=\"pseudo\" value='$p' placeholder='Pseudonyme' required>
                           </div>
                           <div class=\"formulaire\">
                                <input style=\"text-align:center\" type=\"text\" name=\"message\" placeholder='Message (facultatif)'>
                           </div>
                           <div class=\"formulaire\">
                                <input type=\"submit\" value=\"Valider\" />
                           </div>
		               </form>";
        $res = $formulaire;
        $html = <<<END
        <div class="formulaireReservation">
        $res
        </div>
END;
    return $html;
    }

    

    }

