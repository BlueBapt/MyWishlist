<?php

namespace mywishlist\controller;

use Illuminate\Database\Capsule\Manager as DB;
use mywishlist\model\Item;
use mywishlist\vue\VueAfficherItem;
use mywishlist\vue\VueHeader;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AffichageItemController
{
    public static function affichageItem(Request $rq,Response $rs,$args):Response{
        $aic = new AffichageItemController();
        $formulaire = $aic->form();

        $url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];
        $sep = explode("/mywishlist", $url);
        $url = $sep[0] . "/mywishlist";

        if (isset($_POST["id"]) && $aic->verifierExistanceItem($_POST["id"]))
            $_SESSION["idItem"] = $_POST["id"];

        if (!isset($_POST["id"])) {
            $rs->getBody()->write(<<<END
                $formulaire
            END);
        } elseif (isset($_POST["id"]) && !$aic->verifierExistanceItem($_POST["id"])){
            $rs->getBody()->write(<<<END
                $formulaire
                <div style="background-color: red;color: white; height: 2em; width: 50%; margin-top: -21em; margin-left: 25%"><p>L'item n'existe pas</p></div>
            END);
            unset($_SESSION["idItem"]);
        } elseif (isset($_POST["id"]) && $aic->verifierExistanceItem($_POST["id"])) {
            $lien = $url."/item/".$_POST["id"];
            //echo "<a href='$lien'>";
            $rs->getBody()->write(<<<END
                <iframe src="$lien"></iframe>
                <style>
                    iframe{
                        width: 50em;
                        height: 30em;
                        border: none;
                        margin-left: 37.5%;
                    }
                </style>
            END);
        }

        return $rs;
    }

    private function verifierExistanceItem(int $id) : bool {
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();

        try {
            $res = Item::where("id", "=", "$id")->first();
        }catch(\Exception $e){
            echo $e;
        }

        $i = false;
        if ($res !== null)
            $i = true;

        return $i;
    }

    private function form() : string {
        $form = "
            <!DOCTYPE html>
            <html lang='fr'>
            <head>
                <meta charset='UTF-8'>
                <title>MyWishList</title>
            </head>
            <body>
                <form id='formulaire' method='post'>
                    <fieldset id='field'>
                        <legend id='ajt' style='margin-bottom: 1em'>Choix de l'item : </legend>
                        <p class='nom'>
                            <label for='act' style='text-decoration: underline; margin-left: .2em'>ID de l'item : </label>
                            <div class='radio'>
                                <p style='text-decoration: underline; margin-left: .2em'>Id : </p>
                                <input type='number' name='id' id='idItem' required>
                            </div>
                        </p>
                        <input type='submit' value='Valider' id='bt' style='margin-left: .2em'>
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
            </html>
        ";
        return $form;
    }
}