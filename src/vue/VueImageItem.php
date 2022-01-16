<?php

namespace mywishlist\vue;

use Illuminate\Database\Capsule\Manager as DB;
use mywishlist\model\Item;
use mywishlist\model\Liste as Liste;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VueImageItem
{
    public string $name;

    public static function afficherFormulaire(Request $rq, Response $rs, $args):Response{
        /**
        $vueImg = new VueImageItem();
        $nom = $vueImg->formulaireImage("nom");

        if (isset($_POST["name"]))
            $_SESSION["name"] = $_POST["name"];

        if (!isset($_POST["name"]) && !isset($_POST["act"]) && !isset($_POST["img"])){
            unset($_SESSION["name"]);
            $rs->getBody()->write(<<<END
            $nom
            END
            );
        } elseif ($_POST["act"] === "ajout" && isset($_SESSION["name"]) && $vueImg->verifierExistanceItem($_SESSION["name"]) && !isset($_POST["img"])) {
            $ajout = $vueImg->formulaireImage("ajout");
            $rs->getBody()->write(<<<END
                $ajout
            END
            );
        } elseif ($_POST["act"] === "m" && $vueImg->verifierExistanceItem($_SESSION["name"]) && !isset($_POST["img"])) {
            $modifie = $vueImg->formulaireImage("modifie");
            $rs->getBody()->write(<<<END
                $modifie
            END
            );
        } elseif (isset($_POST["name"]) && isset($_POST["act"]) && !$vueImg->verifierExistanceItem($_SESSION["name"]) && !isset($_POST["img"])) {
            $rs->getBody()->write(<<<END
            <div class="error">L'item n'existe pas !</div>
                    <style>
                        .error{
                            background-color: red;
                            width: 50%;
                            margin-left: 25%;
                            color: white;
                            text-align: center;
                            height: 2em;
                        }
                    </style>
            $nom
            END
            );
        }
        if (isset($_POST["img"]) && $_POST["act"] == "ajout") {
            $vueImg->ajoutImage();
            $rs->getBody()->write(<<<END
            $nom
            END
            );
            unset($_POST["act"]);
            unset($_POST["img"]);
            unset($_SESSION["name"]);
        }
        if (isset($_POST["img"]) && $_POST["act"] == "m") {
            $vueImg->modifierImage();
            $rs->getBody()->write(<<<END
            $nom
            END
            );
            unset($_POST["act"]);
            unset($_POST["img"]);
            unset($_SESSION["name"]);
        }*/
        return $rs;
    }

    /**
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

    private function ajoutImage() {
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();

        $id = 0;
        if (isset($_SESSION["name"]))
            $id = $this->idItem($_SESSION["name"]);
        try {
            $res = Item::select("*")->where("id", "like", $id)->get();
        }catch(\Exception $e){
            echo $e;
        }
        $nl = Item::where("id", "=", $id)->first();
        foreach ($res as $r) {
            $nl->nom = $r->nom;
            $nl->descr = $r->descr;
            $nl->liste_id = $r->liste_id;
            $nl->url = $r->url;
            $nl->tarif = $r->tarif;
        }
        //$nl->img=$_POST["img"];


        try {
            $nl->save();
        }catch(\Exception $e){
            echo $e;
        }
    }

    private function modifierImage() {
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();

        $id = $this->idItem($_SESSION["name"]);
        try {
            $res = Item::select("*")->where("id", "like", $id)->get();
        }catch(\Exception $e){
            echo $e;
        }
        $nl = Item::where("id", "=", $id)->first();
        foreach ($res as $r) {
            $nl->nom = $r->nom;
            $nl->descr = $r->descr;
            $nl->liste_id = $r->liste_id;
            $nl->url = $r->url;
            $nl->tarif = $r->tarif;
        }
        $nl->img=$_POST["img"];


        try {
            $nl->save();
        }catch(\Exception $e){
            echo $e;
        }
    }

    private function formulaireImage(string $act):string{
        $ajout = "
        <!DOCTYPE html>
            <html lang='fr'>
            <head>
                <meta charset='UTF-8'>
                <title>MyWishList</title>
            </head>
            <body>
                <form id='formulaire' method='post'>
                    <fieldset id='field'>
                        <legend id='ajt'>Ajout d'image à un item.</legend>
                        <p class='image'>
                            <label for='image'>Entrer votre url ou chemin : </label>
                            <input type='text' name='img' id='image' placeholder='URL ou chemin *' required>
                            <input type='hidden' name='act' id='image' value='ajout'>
                        </p>
                        <input type='submit' value='Valider' id='bt'>
                    </fieldset>
                </form>

                <style>
                    body{
                    background-color: lightgray;
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
            </html>
        ";
        $modifie ="
            <!DOCTYPE html>
            <html lang='fr'>
            <head>
                <meta charset='UTF-8'>
                <title>MyWishList</title>
            </head>
            <body>
                <form id='formulaire' method='post'>
                    <fieldset id='field'>
                        <legend id='ajt'>Modification d'image à d'un item.</legend>
                        <p class='image'>
                            <label for='image'>Entrer votre url ou chemin : </label>
                            <input type='text' name='img' id='image' placeholder='URL ou chemin *' required>
                            <input type='hidden' name='act' id='image' value='m'>
                        </p>
                        <input type='submit' value='Valider' id='bt'>
                    </fieldset>
                </form>

                <style>
                    body{
                        background-color: lightgray;
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
            </html>
        ";
        $nom ="
            <!DOCTYPE html>
            <html lang='fr'>
            <head>
                <meta charset='UTF-8'>
                <title>MyWishList</title>
            </head>
            <body>
                <form id='formulaire' method='post'>
                    <fieldset id='field'>
                        <legend id='ajt'>Modification d'image à d'un item.</legend>
                        <p class='nom'>
                            <label for='name'>Entrer le nom de l'item : </label>
                            <input type='text' name='name' id='name' placeholder='Nom de l item' required>
                        </p>
                        <div class='image'>
                            <label for='act'>Action : </label>
                            <p>Ajout</p>
                            <input type='radio' name='act' id='name' value='ajout' required>
                            <p>Modification</p>
                            <input type='radio' name='act' id='name' value='m' required>
                        </div>
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
            </html>
        ";
        if ($act === "modifie")
            return $modifie;
        elseif ($act === "ajout")
            return $ajout;
        elseif ($act === "nom")
            return $nom;
        else
            return "error";
    }
    */
}