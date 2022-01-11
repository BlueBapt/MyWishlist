<?php

namespace mywishlist\vue;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VueAcceuil
{
    public static function afficherFormulaire(Request $rq, Response $rs, $args):Response{
        $user = "inscription/connexion";
        $co = "https://127.0.0.1/mywishlist/inscription";
        if (isset($_SESSION["user"])) {
            $user = $_SESSION["user"];
            $co = "https://www.youtube.com/watch?v=dQw4w9WgXcQ";
        }
        $rs->getBody()->write(<<<END
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset="utf-8" />
                        <title>My wish list</title>
                        <link rel="stylesheet" href="/acceuil.css">
                    </head>
                    <header>
                        <div class="title">
                            <div class="menu" id="menu">
                                <div class="liste" id="liste">
                                    <button id="listeB"><h2>Liste</h2></button>
                                    <a href="http://127.0.0.1/mywishlist/creer/liste" id="headerA">Ajouter une liste</a>
                                    <a href="" id="headerA">Afficher une liste</a>
                                    <a href="" id="headerA">Modifier une liste</a>
                                    <a href="" id="headerA">Partager une liste</a>
                                </div>
                                <div class="item" id="item">
                                    <button id="itemB"><h2>Item</h2></button>
                                    <a href="http://127.0.0.1/mywishlist/ajout/item" id="headerA">Ajouter un item</a>
                                    <a href="" id="headerA">Supprimer un item</a>
                                    <a href="" id="headerA">Modifier un item</a>
                                    <a href="" id="headerA">Ajouter une image</a>
                                    <a href="" id="headerA">Modifier une image</a>
                                    <a href="" id="headerA">Supprimer une image</a>
                                </div>
                            </div>
                            <h1 class="mwl">My Wish List</h1>
                            <a id="insa" href="$co"><button id="ins">$user</button></a>
                        </div>
                        <script>
                            const item = document.getElementById("item")
                            const liste = document.getElementById("liste")
                            const itemB = document.getElementById("itemB")
                            const listeB = document.getElementById("listeB")
                    
                            let desL = true, desI = true
                            listeB.addEventListener("click", () => {
                                if (desL) {
                                    liste.style.height = 12 +'em'
                                    desL = false
                                }else {
                                    liste.style.height = 2 +'em'
                                    desL = true
                                }
                            })
                            itemB.addEventListener("click", () => {
                                if (desI) {
                                    item.style.height = 16 +'em'
                                    desI = false
                                }else {
                                    item.style.height = 2 +'em'
                                    desI = true
                                }
                            })
                        </script>
                    </header>
                    <body>
                        <div class="pres" id="pres">
                            <div class="presG" id="presG">
                                <h2>Principe du site</h2>
                                <p>MyWishList.app est une application en ligne pour créer, partager et gérer des listes de cadeaux. L'application permet à un utilisateur de créer une liste de souhaits à l'occasion d'un événement particulier (anniversaire, fin d'année, mariage, retraite ...) et lui permet de diffuser cette liste de souhaits à un ensemble de personnes concernées. Ces personnes peuvent alors consulter cette liste et s'engager à offrir 1 élément de la liste. Cet élément est alors marqué comme réservé dans cette liste.</p>
                            </div>
                            <div class="presL">
                                <h2>Principe des listes</h2>
                                <p>Ces fonctionnalités sont réservées à des utilisateurs enregistrés et authentifiés sur l'application.</p>
                                <p style="text-decoration: underline;">Un utilisateur enregistré peut donc :</p>
                                <ul>
                                    <li>créer une nouvelle liste en lui donnant un titre, une description, une date limite de validité.</li>
                                    <li>à tout moment tant que la liste est valide, il peut ajouter des items dans la liste.</li>
                                    <li>un item est caractérisé par un nom, un descriptif textuel et un tarif indicatif. Il peut être accompagné d'une url et éventuellement d'une ou plusieurs images.</li>
                                    <li>il peut partager cette liste : pour cela il demande à l'application de générer une url qu'il diffuse ensuite par ses propres moyens. L'url contient un token unique identifiant la liste.</li>
                                    <li>il peut à tout moment consulter la liste et voir quels sont les items sélectionnés, par contre il ne peut pas voir qui a choisi l'item.</li>
                                    <li>après la date limite de validité, le créateur peut consulter la liste et lire les différents messages associés à chaque cadeau de la liste et laissés par les utilisateurs ayant choisi ce cadeau</li>
                                </ul>
                            </div>
                            <div class="presI">
                                <h2>Principe des items</h2>
                                <p>Un destinataire de liste est une personne qui reçoit par mail une url lui permettant de participer à une liste de cadeau. L'url lui permet d'accéder à la liste de cadeaux. Il visualise le titre la description et la date limite de validité de la liste, ainsi que la liste des items. Les items déjà réservés sont indiqués.</p>
                                <p style="text-decoration: underline;">Il pourra :</p>
                                <ul>
                                    <li>choisir de réserver un item, en précisant son nom,</li>
                                    <li>ajouter un message avec une réservation d'item. Ce message est destiné au destinataire du cadeau</li>
                                    <li>ajouter un message ou un commentaire global destiné à l'ensemble des utilisateurs</li>
                                </ul>
                            </div>
                        </div>
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
                            
                            #ins{
                                border: none;
                                height: 2em;
                            }
                            
                            
                            #insa{
                                height: 2em;
                            }
                            
                            .pres{
                                display: flex;
                                flex-direction: row;
                                justify-content: space-between;
                                margin-left: 5em;
                                margin-right: 5em;
                                margin-top: 5%;
                            }
                            
                            .presG, .presL, .presI{
                                background-color: black;
                                color: white;
                                width: 30%;
                                padding: .5em;
                            }
                            
                            .presG > h2, .presL > h2, .presI > h2{
                                color: violet;
                                text-decoration: underline;
                                margin-bottom: 1em;
                            }
                            
                            .presG > p, .presL > p, .presI > p{
                                margin-bottom: 1em;
                            }
                            
                            .presG > ul > li, .presL > ul > li, .presI > ul > li{
                                margin-bottom: .1em;
                                margin-left: .7em;
                            }
                        </style>
                    </body>
                END
        );
        return $rs;
    }
}