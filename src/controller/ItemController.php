<?php

namespace mywishlist\controller;
require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use mywishlist\model\Item;
use mywishlist\model\Liste;
use mywishlist\vue\VueAjoutItem;
use mywishlist\vue\VueHeader;
use mywishlist\vue\VueItemSup;
use Slim\Http\Request;
use Slim\Http\Response;

class ItemController
{
    public static function itemAction(Request $rq, Response $rs, $args): Response
    {
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();

        $rs = VueHeader::afficherFormulaire($rq, $rs, $args);

        $ic = new ItemController();
        $acc = $ic->form();

        if (!isset($_POST["actionAcc"])) {
            $rs->getBody()->write(<<<END
            $acc
        END);
        }

        if (isset($_POST["name"]))
            $_SESSION["name"] = $_POST["name"];

        //oscar de la meilleur fonctionnalite
        if (isset($_SESSION["name"]) && !$ic->verifierExistanceItem($_SESSION["name"])) {
            unset($_SESSION["name"]);
            $rs->getBody()->write(<<<END
                <div id='error' style='background-color: red;width: 50%; height: 2em; margin-left: 25%;text-align: center; color: white'>
                    <p>L'item n'existe pas ou a été supprimé</p>
                </div>
            END
            );
        }

        if (isset($_POST["actionAcc"]) && $_POST["actionAcc"] == "ajout") {
            //$rs = VueAjoutItem::afficherFormulaire($rq, $rs, $args);
        } elseif (isset($_POST["actionAcc"]) && $_POST["actionAcc"] == "sup") {
            if (!isset($_SESSION["name"])){
                VueItemSup::acceuil($rq, $rs, $args);
                header(1);
            }

            if (isset($_SESSION["name"]) && $ic->verifierExistanceItem($_SESSION["name"])) {
                VueItemSup::verification($rq, $rs, $args);
            }
        }

        if (isset($_SESSION["name"]) && isset($_POST["verif"]) && $_POST["verif"] == "yes") {
            $ic->sup($ic->idItem($_SESSION["name"]));
            header(1);
        } elseif (isset($_SESSION["name"]) && isset($_POST["verif"]) && $_POST["verif"] == "no"){
            unset($_SESSION["name"]);
        }

        if (isset($_POST["verif"]) && $_POST["verif"] == "no" || isset($_POST["verif"]) && $_POST["verif"] == "yes") {
            header(1);
        }
        return $rs;
    }

    private function verifierExistanceListe(String $token) : bool {
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();

        try {
            $res = Liste::select("token")->get();
        }catch(\Exception $e){
            echo $e;
        }
        $i = false;
        foreach ($res as $r => $s){
            $t = explode(":", $s);
            $tn = $t[1];
            $t = explode("}", $tn);
            $tn = $t[0];
            $t = explode("\"", implode($t));
            if (isset($t[1]))
                $tn = $t[1];
            if ($tn === $token)
                $i = true;
        }
        return $i;
    }

    private function verifierExistanceItem(String $nom) : bool {
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();

        try {
            $res = Item::select("nom")->get();
        }catch(\Exception $e){
            echo $e;
        }
        $i = false;
        foreach ($res as $r => $s){
            $t = explode(":", $s);
            $tn = $t[1];
            $t = explode("}", $tn);
            $tn = $t[0];
            $t = explode("\"", implode($t));
            if (isset($t[1]))
                $tn = $t[1];
            if ($tn === $nom) {
                $i = true;
                break;
            }
        }
        return $i;
    }

    private function verifierExistanceItemDescr(String $nom, String $descr) : bool {
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();

        try {
            $res = Item::select("nom")->get();
            $res2 = Item::select("descr")->get();
        }catch(\Exception $e){
            echo $e;
        }
        $i = false;
        foreach ($res as $r => $s){
            $t = explode(":", $s);
            $tn = $t[1];
            $t = explode("}", $tn);
            $tn = $t[0];
            $t = explode("\"", implode($t));
            if (isset($t[1]))
                $tn = $t[1];
            if ($tn === $nom) {
                $i = true;
                break;
            }
        }
        if ($i)
            foreach ($res2 as $r => $s){
                $t = explode(":", $s);
                $tn = $t[1];
                $t = explode("}", $tn);
                $tn = $t[0];
                $t = explode("\"", implode($t));
                if (isset($t[1]))
                    $tn = $t[1];
                if ($tn === $descr) {
                    $i = true;
                    break;
                }
            }
        return $i;
    }

    private function idListe(String $token) : int {
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();

        try {
            $res = Liste::where("token", "=", "$token")->get();
        }catch(\Exception $e){
            echo $e;
        }
        $i = 0;
        foreach ($res as $r => $s){
            $t = explode(",", $s);
            $tn = $t[0];
            $t = explode(":", $tn);
            $tn = $t[1];
            $i = $tn;
        }
        return $i;
    }

    private function idItem(String $nom) : int {
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();

        try {
            $res = Item::where("nom", "=", "$nom")->get();
        }catch(\Exception $e){
            echo $e;
        }
        $i = 0;
        foreach ($res as $r => $s){
            $t = explode(",", $s);
            $tn = $t[0];
            $t = explode(":", $tn);
            $tn = $t[1];
            $i = $tn;
        }
        return $i;
    }

    private function sup(int $idItem){
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();

        try {
            $res = Item::select("*")->where("id", "like", $idItem)->get();
        }catch(\Exception $e){
            echo $e;
        }

        $nl = Item::where("id", "=", $idItem)->first();

        try {
            $nl->delete();
        } catch (\Throwable $t) {
            echo $t;
        }
        unset($_SESSION["name"]);
    }

    private function form() : string{
        return "<!DOCTYPE html>
            <html lang='fr'>
            <head>
                <meta charset='UTF-8'>
                <title>MyWishList</title>
            </head>
            <body>
                <form id='formulaire' method='post'>
                    <fieldset id='field'>
                        <legend id='ajt' style='margin-bottom: 1em'>Action sur l'item : </legend>
                        <p class='nom'>
                            <label for='act' style='text-decoration: underline'>Action : </label>
                            <div class='radio'>
                                <p>Ajout</p>
                                <input type='radio' name='actionAcc' id='action' value='ajout' required>
                            </div>
                            <div class='radio'>
                                <p>Modification</p>
                                <input type='radio' name='actionAcc' id='action' value='modif' required>
                            </div>
                            <div class='radio'>
                                <p>Suppression</p>
                                <input type='radio' name='actionAcc' id='action' value='sup' required>
                            </div>
                            <div class='radio'>
                                <p>Ajout Image</p>
                                <input type='radio' name='actionAcc' id='action' value='ajoutImg' required>
                            </div>
                            <div class='radio'>
                                <p>Modification Image</p>
                                <input type='radio' name='actionAcc' id='action' value='modifImg' required>
                            </div>
                            <div class='radio'>
                                <p>Suppression Image</p>
                                <input type='radio' name='actionAcc' id='action' value='supImg' required>
                            </div>
                        </p>
                        <input type='submit' value='Valider' id='bt'>
                    </fieldset>
                </form>

                <style>
                    body{
                        background-color: lightgray;
                            }
                        .image{
                            display: flex;
                            flex-direction: row;
                            color: white;
                        }
                        
                            form{
                        width: 50%;
                        grid-column: 2;
                                background-color: rgb(22, 31, 41);
                                border: .3em ridge white;
                                margin-left: 25%;
                                height: 19em;
                            }
                        
                            form > fieldset > p{
                        color: white;
                        margin-bottom: 1.1em;
                            }
                        
                            form > fieldset{
                        height: calc(100% - 1.5em);
                                width: calc(100% - 2em);
                            }
                        
                            legend{
                        color: white;
                    }
                        
                            .img > input {
                        color: black;
                        border: .1em solid white;
                                border-radius: .1em;
                                background-color: white;
                                border: none;
                            }
                            
                            #descr{
                                width: 50%;
                            }
            
                #bt:hover, #btnURL:hover{
            border-radius: .2em;
            transform: scale(1.02);
            }
            .radio{
                display: flex;
                flex-direction: row;
                color: white;
            }
            .radio > p{
                margin-right: 1em;
                margin-bottom: .5em;
            }
            </style>
             
            </body>
            </html>";
    }
}