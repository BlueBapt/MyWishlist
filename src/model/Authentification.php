<?php

namespace mywishlist\model;

require_once "src/BaseDeDonnees.php";

use Illuminate\Database\Capsule\Manager as DB;

class Authentification
{
    public static int $ADMIN=5;
    public static int $MODERATEUR=4;
    public static int $USER=3;
    public static int $NON_AUTHENTIFIE=2;

    public static function authentification($login,$mdp){
        $db =$db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();
        $reserv = Utilisateur::select("psuedo", "mdp")->where("psuedo", "=", $login)->get();
        $trouve = false;
        $mdp = hash("md5", $mdp . "énormetonmdpMeccéFOUUUUUUuIncroy4bl3");
        foreach ($reserv as $r) {
            if (!$trouve) {
                echo "<br>". $r->mdp . "   |   ".$mdp;
                if ($r->mdp === $mdp) {
                    $trouve = true;
                    self::chargerProfil($login);
                    echo "aaaaa";
                }
            }
        }
        return $trouve;
    }

    private static function chargerProfil($login){
        session_start();
        if (isset($_SESSION["user"])) {
            unset($_SESSION["user"]);
        }
        $_SESSION["user"] = $login;
        $db =$db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();
        $droits = Utilisateur::select("psuedo", "droits")->where("psuedo", "=", $login)->get()->first();
        $_SESSION["rights"] = $droits;
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
        $db =$db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();
        $nl = new Utilisateur();
        $nl->psuedo = $psuedo;
        $mdp=hash("md5",($mdp ."énormetonmdpMeccéFOUUUUUUuIncroy4bl3"));
        $nl->mdp = $mdp;
        $nl->droits =$droits;
        $nl->save();
        return true;
    }
}