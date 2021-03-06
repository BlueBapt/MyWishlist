<?php

namespace mywishlist\controller;
require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use mywishlist\model\Item;
use mywishlist\model\Liste;
use mywishlist\vue\VueAjoutItem;
use mywishlist\vue\VueHeader;
use mywishlist\vue\VueImageItem;
use mywishlist\vue\VueItemSup;
use mywishlist\vue\VueModifItem;
use Slim\Http\Request;
use Slim\Http\Response;

class ItemController
{
    public static function itemAction(Request $rq, Response $rs, $args): Response
    {
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'root','password'=>'','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();

        $rs = VueHeader::afficherFormulaire($rq, $rs, $args);

        $ic = new ItemController();
        $acc = $ic->form();

        if (isset($_POST["name"]))
            $_SESSION["name"] = $_POST["name"];
        if (isset($_POST["actionAcc"]))
            $_SESSION["actionAcc"] = $_POST["actionAcc"];

        if (!isset($_SESSION["actionAcc"]) && !isset($_SESSION["name"]) || !isset($_SESSION["actionAcc"])) {
            $rs->getBody()->write(<<<END
            $acc
        END);
        }

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
            $rs = VueAjoutItem::formulaire($rq, $rs, $args);
            unset($_SESSION["actionAcc"]);
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
            unset($_SESSION["actionAcc"]);
            header(1);
        } elseif (isset($_SESSION["name"]) && isset($_POST["verif"]) && $_POST["verif"] == "no"){
            unset($_SESSION["name"]);
            unset($_SESSION["actionAcc"]);
        }

        if (isset($_POST["verif"]) && $_POST["verif"] == "no" || isset($_POST["verif"]) && $_POST["verif"] == "yes") {
            header(1);
            unset($_SESSION["actionAcc"]);
        }


        if(isset($_POST["description"]) && isset($_POST["nomItem"]) && isset($_POST["tarif"]) && isset($_POST["token"])){
            if ($ic->verifierExistanceListe($_POST["token"]) && !$ic->verifierExistanceItem($_POST["nomItem"])){
                $ic->ajouterItem($ic->idListe($_POST["token"]));
                $rs->getBody()->write(<<<END
                    <div class="reussite" >L'opération est une réussite!</div>
                    <style>
                        .reussite{
                            background-color: green;
                            width: 50%;
                            margin-left: 25%;
                            color: white;
                            text-align: center;
                            height: 2em;
                        }
                    </style>
                END);
                unset($_SESSION["actionAcc"]);
            } else if(!$ic->verifierExistanceListe($_POST["token"])){
                $rs->getBody()->write(<<<END
                    <div class="reussite">La liste n'existe pas !!!</div>
                    <style>
                        .reussite{
                            background-color: red;
                            width: 50%;
                            margin-left: 25%;
                            color: white;
                            text-align: center;
                            height: 2em;
                        }
                    </style>
                END);
            }else if($ic->verifierExistanceItem($_POST["nomItem"])){
                $rs->getBody()->write(<<<END
                    <div class="reussite">L'item existe déjà !</div>
                    <style>
                        .reussite{
                            background-color: red;
                            width: 50%;
                            margin-left: 25%;
                            color: white;
                            text-align: center;
                            height: 2em;
                        }
                    </style>
                END);
            }else if(!$ic->verifierExistanceListe($_POST["token"])){
                $rs->getBody()->write(<<<END
                    <div class="reussite">La liste n'existe pas !!!</div>
                    <style>
                        .reussite{
                            background-color: red;
                            width: 50%;
                            margin-left: 25%;
                            color: white;
                            text-align: center;
                            height: 2em;
                        }
                    </style>
                END);
            }
        }

        if (isset($_SESSION["actionAcc"]) && $_SESSION["actionAcc"] == "ajoutImg" || isset($_SESSION["actionAcc"]) && $_SESSION["actionAcc"] == "modifImg") {
            if (!isset($_SESSION["name"]) && !isset($_POST["img"])){
                unset($_SESSION["name"]);
                VueImageItem::acceuil($rq, $rs, $args);
            }

            if (isset($_SESSION["actionAcc"]) && $_SESSION["actionAcc"] === "ajoutImg" && isset($_SESSION["name"]) && $ic->verifierExistanceItem($_SESSION["name"]) && !isset($_POST["img"])) {
                VueImageItem::ajouterImage($rq, $rs, $args);
            } elseif (isset($_SESSION["actionAcc"]) && $_SESSION["actionAcc"] === "modifImg" && isset($_SESSION["name"]) && $ic->verifierExistanceItem($_SESSION["name"]) && !isset($_POST["img"])) {
                VueImageItem::modifierImage2($rq, $rs, $args);
            } elseif (isset($_POST["name"]) && isset($_SESSION["actionAcc"]) && isset($_SESSION["name"]) && !$ic->verifierExistanceItem($_SESSION["name"]) && !isset($_POST["img"])) {
                VueImageItem::acceuil($rq, $rs, $args);
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
            END
                );
                unset($_SESSION["name"]);
            }
        }

        if (isset($_POST["img"]) && isset($_SESSION["actionAcc"]) && $_SESSION["actionAcc"] == "ajoutImg") {
            $ic->ajoutImage();
            echo "<h1 style='color: white'>Image ajouté</h1><br><h2 style='color: white'>Veuillez refresh la page</h2>";
            unset($_SESSION["actionAcc"]);
            unset($_POST["img"]);
            unset($_SESSION["name"]);
        }
        if (isset($_POST["img"]) && isset($_SESSION["actionAcc"]) && $_SESSION["actionAcc"] == "modifImg") {
            $ic->modifierImage();
            echo "<h1 style='color: white'>Image modifié</h1><br><h2 style='color: white'>Veuillez refresh la page</h2>";
            unset($_SESSION["actionAcc"]);
            unset($_POST["img"]);
            unset($_SESSION["name"]);
        }

        if (isset($_SESSION["actionAcc"]) && $_SESSION["actionAcc"] == "supImg") {
            if (!isset($_SESSION["name"])) {
                VueImageItem::acceuil($rq, $rs, $args);
            }
            header(1);
        }

        if (isset($_SESSION["name"]) && isset($_SESSION["actionAcc"]) && $_SESSION["actionAcc"] == "supImg") {
            $ic->supImage();
            echo "<h1 style='color: white'>Image supprimé</h1><br><h2 style='color: white'>Veuillez refresh la page</h2>";
            unset($_SESSION["name"]);
            unset($_SESSION["actionAcc"]);
            header(1);
        }

        if (isset($_SESSION["actionAcc"]) && $_SESSION["actionAcc"] == "modif") {
            VueModifItem::formulaire($rq, $rs, $args);
            if (isset($_SESSION["name"])) {
                $ic->modifItem();
                unset($_POST["descriptionModif"]);
                unset($_POST["tokenModif"]);
                unset($_POST["urlModif"]);
                unset($_POST["tarifModif"]);
                if (isset($_POST["good"]) && $_POST["good"] == 1) {
                    unset($_SESSION["actionAcc"]);
                    unset($_POST["actionAcc"]);
                    unset($_POST["name"]);
                    unset($_SESSION["name"]);
                    echo "<h1 style='color: white'>Modification effectué</h1><br><h2 style='color: white'>Veuillez refresh la page</h2>";
                }
            }
        }

        return $rs;
    }

    private function verifierExistanceListe(String $token) : bool {
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'root','password'=>'','charset'=>'utf8','collation'=>'utf8_unicode_ci',
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
            'username'=>'root','password'=>'','charset'=>'utf8','collation'=>'utf8_unicode_ci',
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
            'username'=>'root','password'=>'','charset'=>'utf8','collation'=>'utf8_unicode_ci',
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
            'username'=>'root','password'=>'','charset'=>'utf8','collation'=>'utf8_unicode_ci',
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
            'username'=>'root','password'=>'','charset'=>'utf8','collation'=>'utf8_unicode_ci',
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
            'username'=>'root','password'=>'','charset'=>'utf8','collation'=>'utf8_unicode_ci',
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

    private function ajouterItem(int $idListe) {
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'root','password'=>'','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();

        try {
            $res = Item::select("*")->get();
        }catch(\Exception $e){
            echo $e;
        }
        $i =1;
        foreach ($res as $r)
            $i++;

        $nl = new Item();
        $nl->id=$i;
        $nl->liste_id=$idListe;
        $nl->nom=$_POST["nomItem"];
        $nl->descr=$_POST["description"];
        if (isset($_POST["img"]))
            $nl->img=$_POST["img"];
        $nl->tarif=$_POST["tarif"];

        try {
            $nl->save();
        }catch(\Exception $e){
            echo $e;
        }
    }

    private function ajoutImage() {
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'root','password'=>'','charset'=>'utf8','collation'=>'utf8_unicode_ci',
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
        $nl->img=$_POST["img"];


        try {
            $nl->save();
        }catch(\Exception $e){
            echo $e;
        }
    }

    private function modifierImage() {
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'root','password'=>'','charset'=>'utf8','collation'=>'utf8_unicode_ci',
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

    private function supImage() {
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'root','password'=>'','charset'=>'utf8','collation'=>'utf8_unicode_ci',
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
        $nl->img=null;


        try {
            $nl->save();
        }catch(\Exception $e){
            echo $e;
        }
    }

    private function modifItem() {
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'root','password'=>'','charset'=>'utf8','collation'=>'utf8_unicode_ci',
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
            $nl->liste_id = $r->liste_id;

            if (isset($_POST["descriptionModif"]) && $_POST["descriptionModif"] != null)
                $nl->descr = $_POST["descriptionModif"];
            else
                $nl->descr = $r->descr;

            if (isset($_POST["tokenModif"]) && $_POST["tokenModif"] != null)
                $nl->liste_id = $this->idListe($_POST["tokenModif"]);
            else
                $nl->liste_id = $r->liste_id;

            if (isset($_POST["urlModif"]) && $_POST["urlModif"] != null)
                $nl->url = $_POST["urlModif"];
            else
                $nl->url = $r->url;

            if (isset($_POST["tarifModif"]) && $_POST["tarifModif"] != null)
                $nl->tarif = $_POST["tarifModif"];
            else
                $nl->tarif = $r->tarif;
        }

        try {
            $nl->save();
        }catch(\Exception $e){
            echo $e;
        }
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