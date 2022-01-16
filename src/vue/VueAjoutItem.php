<?php

namespace mywishlist\vue;

namespace mywishlist\vue;
use mywishlist\model\Item;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \mywishlist\model\Liste as Liste;
require_once 'vendor/autoload.php';
require_once 'src/model/Liste.php';
use Illuminate\Database\Capsule\Manager as DB;

class VueAjoutItem
{
    public static function afficherFormulaire(Request $rq, Response $rs, $args):Response{
        $user = "inscription/connexion";
        $co = "https://127.0.0.1/mywishlist/inscription";
        if (isset($_SESSION["user"])) {
            $user = $_SESSION["user"];
            $co = "https://www.youtube.com/watch?v=dQw4w9WgXcQ";
        }

        $margin = "9%";
        if(isset($_GET["description"]) && isset($_GET["nom"]) && isset($_GET["tarif"]) && isset($_GET["token"])){
            $vai = new VueAjoutItem();
            $margin = "0%";
            if ($vai->verifierExistance($_GET["token"]) && !$vai->verifierExistanceItem($_GET["nom"], $_GET["description"])){
                $vai->ajouterItem();
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
                            margin-top: 7%;
                        }
                    </style>
                END);
            } else if(!$vai->verifierExistance($_GET["token"])){
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
                            margin-top: 7%;
                        }
                    </style>
                END);
            }else if($vai->verifierExistanceItem($_GET["nom"], $_GET["description"])){
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
                            margin-top: 7%;
                        }
                    </style>
                END);
            }else if(!$vai->verifierExistance($_GET["token"])){
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
                            margin-top: 7%;
                        }
                    </style>
                END);
            }
        }
        $rs->getBody()->write(<<<END
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <title>MyWishList</title>
            </head>
            <body>
                <form id="formulaire">
                    <fieldset id="field">
                        <legend id="ajt">Ajout d'item dans la liste.</legend>
                        <p class="token">
                            <label for="nom">Entrer le token : </label>
                            <input type="text" name="token" id="token" placeholder="token" required>
                        </p>
                        <p class="nom">
                            <label for="nom">Entrer le nom : </label>
                            <input type="text" name="nom" id="nom" placeholder="NOM *" required>
                        </p>
                        <p class="description">
                            <label for="description">Entrer votre description : </label>
                            <input type="text" name="description" id="descr" placeholder="DESCRIPTION *" required>
                        </p>
                        <p class="tarif">
                            <label for="nom">Entrer votre tarif : </label>
                            <input type="number" name="tarif" id="tarif" required>
                        </p>
                        <button id="btnURL">URL ?</button>
                        <input type="submit" value="Valider" id="bt">
                    </fieldset>
                </form>

                <style>
                    *,
                    ::before,
                    ::after{
                        margin: 0;
                        padding: 0;
                        box-sizing: border-box;
                    }
                    
                    header{
                        position: relative;
                        background-color: black;
                        color: yellow;
                        z-index: 2;
                    }
                    
                    body{
                        position: relative;
                        z-index: 1;
                        background-color: gray;
                    }
                    
                    .title{
                        display: flex;
                        flex-direction: row;
                        justify-content: space-between;
                        margin-left: 2em;
                        margin-right: 2em;
                        height: 4em;
                    }
                    
                    .menu{
                        width: 20em;
                        height: 2em;
                        display: flex;
                        flex-direction: row;
                        margin-top: 1em;
                        justify-content: flex-end;
                    }
                    
                    #headerA{
                        text-decoration: none;
                        color: white;
                    }
                    
                    a{
                        margin-top: 1em;
                    }
                    
                    .mwl{
                        margin-left: -5em;
                        margin-top: .4em;
                    }
                    
                    .item{
                        border: .1em solid white;
                        width: 50%;
                        margin-left: 1em;
                        display: flex;
                        flex-direction: column;
                        text-align: center;
                        overflow: hidden;
                        background-color: black;
                    }
                    
                    .liste{
                        border: .1em solid white;
                        width: 50%;
                        height: 2em;
                        display: flex;
                        flex-direction: column;
                        text-align: center;
                        overflow: hidden;
                        background-color: black;
                    }
                    
                    #itemB, #listeB{
                        border: none;
                        background-color: black;
                        color: yellow;
                        cursor: pointer;
                    }
                    
                    #insa{
                        height: 2em;
                    }
                    
                    #insc{
                        border: none;
                        height: 2em;
                    }
            
                    form{
                        width: 50%;
                        grid-column: 2;
                        background-color: rgb(22, 31, 41);
                        border: .3em ridge white;
                        margin-left: 25%;
                        height: 14.5em;
                        margin-top: $margin;
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
                <script>
                    const url = document.getElementById("btnURL")
                    const form = document.getElementById("field")
                    url.addEventListener("click", () => {
                        form.innerHTML += '<input type="text" name="url" placeholder="URL" id="img">'
                    })
                </script>
            </body>
            </html>
            END
        );
        return $rs;
    }

    private function verifierExistance(String $token) : bool {
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

    private function verifierExistanceItem(String $nom, String $descr) : bool {
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

    private function ajouterItem() {
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
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
        $nl->liste_id=$this->idListe($_GET["token"]);
        $nl->nom=$_GET["nom"];
        $nl->descr=$_GET["description"];
        if (isset($_GET["img"]))
            $nl->img=$_GET["img"];
        $nl->tarif=$_GET["tarif"];

         try {
             if (!$this->verifierExistanceItem($_GET["nom"], $_GET["description"]))
                 $nl->save();
         }catch(\Exception $e){
             echo $e;
         }
    }
}