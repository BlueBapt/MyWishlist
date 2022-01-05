<?php

namespace mywishlist\model;
require_once  '../vendor/autoload.php';

use Exception;
use mywishlist\BaseDeDonnees as BDD;

class Authentification
{
    public static int $ADMIN=5;
    public static int $MODERATEUR=4;
    public static int $USER=3;
    public static int $NON_AUTHENTIFIE=2;

    public static function authentification($login,$mdp){
        $db = BDD::getDB();
        $reserv = Reservation::select("psuedo","mdp")->where("psuedo","=",$login)->get();
        $trouve=false;
        $mdp=$mdp.hash("md5",$mdp."énormetonmdpMeccéFOUUUUUUuIncroy4bl3");
        foreach ($reserv as $r) {
            if(!$trouve) {
                if($r->mdp === $mdp){
                    $trouve = true;
                    self::chargerProfil($login);
                }
            }
        }
        return $trouve;
    }

    private static function chargerProfil($login){
        session_start();
        if(isset($_SESSION["user"])){
            unset($_SESSION["user"]);
        }
        $_SESSION["user"]=$login;
        $db = BDD::getDB();
        $droits = Reservation::select("psuedo","droits")->where("psuedo","=",$login)->get()->first();
        $_SESSION["rights"]=$droits;
    }

    public static function checkDroits($droitsRequis):bool{
        session_start();
        if(!isset($_SESSION["rights"])){
            return false;
        }else {
            $u_droits = $_SESSION["rights"];
            return ($u_droits >= $droitsRequis);
        }
    }

    public static function creerUtilisateur($psuedo,$mdp,$droits) : bool{
        try {
            $nl = new Utilisateur();
            $nl->psuedo = $psuedo;
            $mdp=$mdp.hash("md5",$mdp."énormetonmdpMeccéFOUUUUUUuIncroy4bl3");
            $nl->mdp = $mdp;
            $nl->droits =$droits;
            $nl->save();
            return true;
        }catch(Exception $e){
            echo $e;
            return false;
        }
    }
}