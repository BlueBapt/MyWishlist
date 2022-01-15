<?php

namespace mywishlist\vue;

use Illuminate\Database\Capsule\Manager as DB;
use mywishlist\model\Item;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VueItemSup
{

    public static function afficherFormulaire(Request $rq, Response $rs, $args):Response{
        $vue = new VueItemSup();
        $sup = $vue->form("acceuil");

        if (isset($_POST["name"]))
            $_SESSION["name"] = $_POST["name"];
        if (isset($_SESSION["name"]) && !$vue->verifierExistanceItem($_SESSION["name"])) {
            unset($_SESSION["name"]);
            $notExist = $vue->form("inexist");
            $rs->getBody()->write(<<<END
                $notExist
            END
            );
        }

        if (!isset($_SESSION["name"])){
            $rs->getBody()->write(<<<END
                $sup
            END
            );
        }
        if (isset($_SESSION["name"]) && $vue->verifierExistanceItem($_SESSION["name"])) {
            $res = $vue->form("verif");
            $rs->getBody()->write(<<<END
                $res
            END
            );
        }
        if (isset($_SESSION["name"]) && isset($_POST["verif"]) && $_POST["verif"] == "yes") {
            $vue->sup($vue->idItem($_SESSION["name"]));
            header(1);
        } elseif (isset($_SESSION["name"]) && isset($_POST["verif"]) && $_POST["verif"] == "no"){
            unset($_SESSION["name"]);
            header(1);
        }
        if (isset($_POST["verif"]) && $_POST["verif"] == "no" || isset($_POST["verif"]) && $_POST["verif"] == "yes")
            header(1);

        return $rs;
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

    private function form(string $name) : string{
        $val = null;
        if (isset($_SESSION["name"]))
            $val = $_SESSION["name"];
        $acceuil = "<!DOCTYPE html>
            <html lang='fr'>
            <head>
                <meta charset='UTF-8'>
                <title>MyWishList</title>
            </head>
            <body>
                <form id='formulaire' method='post'>
                    <fieldset id='field'>
                        <legend id='ajt'>Suppression d'un item.</legend>
                        <p class='nom'>
                            <label for='name'>Entrer le nom de l'item : </label>
                            <input type='text' name='name' id='name' placeholder='Nom de l item' required>
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
                                height: 14.5em;
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
            </style>
             
            </body>
            </html>";
        $notExist = "
            <div id='error' style='background-color: red;width: 50%; height: 2em; margin-left: 25%;text-align: center; color: white'>
                <p>L'item n'existe pas ou a été supprimé</p>
            </div>
        ";
        $existPlus = "
            <div id='error' style='background-color: green;width: 50%; height: 2em; margin-left: 25%;text-align: center; color: white'>
                <p>L'item a été suprimé</p>
            </div>
        ";
        $v = "
        <!DOCTYPE html>
            <html lang='fr'>
            <head>
                <meta charset='UTF-8'>
                <meta http-equiv='refresh' content='3'>
                <title>MyWishList</title>
            </head>
            <body>
                <form id='formulaire' method='post'>
                    <fieldset id='field'>
                        <legend id='ajt'>Suppression d'un item.</legend>
                        <p class='nom'>
                            <label for='name'>Etes-vous sûre ? : </label>
                            <div class='radio'>
                                <div>
                                    <p style='margin-right: 1em'>Oui</p>
                                    <input type='radio' name='verif' id='name' value='yes' required>
                                </div>
                                <div>
                                    <p style='margin-right: 1em'>Non</p>
                                    <input type='radio' name='verif' id='name' value='no' required>
                                </div>
                            </div>
                            <input type='hidden' name='$val' id='name' required>
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
                                height: 14.5em;
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
                            flex-direction: column; 
                        }
                        .radio>*{
                            display: flex;
                            flex-direction: row;
                            color: white;                           
                        }
                        
                </style>
             
            </body>
            </html>";

        if ($name == "acceuil")
            return $acceuil;
        elseif ($name == "inexist")
            return $notExist;
        elseif ($name == "verif") {
            return $v;
        }
        elseif ($name == "ep")
            return $existPlus;
        else {
            return "error";
        }
    }
}