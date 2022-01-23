<?php

namespace mywishlist\vue;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use mywishlist\model\Item as Item;
require_once 'vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as DB;


class VueAfficherItem
{
    public static function affichageItem(Request $rq,Response $rs,$args):Response{
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();
        $item = Item::select('id', 'liste_id', 'nom', 'descr', 'img', 'tarif')->where('id', '=', $args)->get();
        $image = null;
        $listeId = null;
        $id = null;
        $nom = null;
        $descr = null;
        $tarif = null;
        foreach ($item as $c) {
            if ($c->first() != null) {
                $image = '../img/'.$c->img;
                $listeId = $c->liste_id;
                $id = $c->id;
                $nom = $c->nom;
                $descr = $c->descr;
                $tarif = $c->tarif;
                if (str_starts_with($c->img, "http"))
                    $image = $c->img;
            }
        }

        if (!isset($_SESSION["idItem"])) {
            VueHeader::afficherFormulaire($rq, $rs, $args);
            $rs->getBody()->write(<<<END
                <style>
                    .form{
                        margin-left: 37.5%;
                    }
                </style>
            END);
        }
        $rs->getBody()->write(<<<END
            <div class="form">
                <div class="descr">
                    <div class="nom"><p id="nom" style="text-decoration: underline">$nom</p><p id="id">id=$id</p></div>
                    <hr>
                    <p id="li" style="margin-left: .5em"><u>Liste :</u> $listeId</p>
                    <p id="dI" style="margin-left: .5em"><u>Description :</u> $descr</p>
                    <p id="tarif" style="margin-left: .5em"><u>Tarif :</u> $tarif</p>
                </div>
                <img src='$image' width='300em'>
            </div>
            <style>
                .form{
                    width: calc(20% + 10em);
                    display: flex;
                    flex-direction: row;
                    justify-content: space-between;
                    border: .1em solid black;
                    background-color: darkslateblue;
                    color: white;
                }
                .form > img{
                    border: .3em ridge white;
                }
                .descr{
                    width: 100%;
                }
                .nom{
                    display: flex;
                    flex-direction: row;
                    justify-content: space-between;
                }
                #id{
                    border: .1em solid white;
                    margin-right: .5em;
                    margin-top: .5em;
                    padding: .2em;
                }
                hr{
                    height: .1em;
                    background-color: black;
                    margin-bottom: 1em;
                }
                #nom{
                    margin-left: .5em;
                    margin-top: .5em;
                    padding: .2em;
                }
                p{
                    margin-bottom: 1em;
                    margin-right: .2em;
                }
                
                @media screen and (max-width: 50em) {
                    .form{
                        width: calc(20% + 25em)
                    }
                }
            </style>
        END
        );
        if (isset($_SESSION["idItem"]))
            unset($_SESSION["idItem"]);
        return $rs;
    }
}