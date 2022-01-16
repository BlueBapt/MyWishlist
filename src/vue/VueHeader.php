<?php

namespace mywishlist\vue;

use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VueHeader
{
    public static function afficherFormulaire(Request $rq, Response $rs, $args):Response
    {

        $user = "inscription/connexion";
        $co = "https://127.0.0.1/mywishlist/inscription";
        if (isset($_SESSION["user"])) {
            $user = $_SESSION["user"];
            $co = "https://www.youtube.com/watch?v=dQw4w9WgXcQ";
        }
        $rs->getBody()->write(<<<END
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
                                    <a href="http://127.0.0.1/mywishlist/modifie/item" id="headerA">Modifier un item</a>
                                    <a href="" id="headerA">Ajouter une image</a>
                                    <a href="" id="headerA">Modifier une image</a>
                                    <a href="" id="headerA">Supprimer une image</a>
                                </div>
                            </div>
                            <h1 class="mwl"><a href="/mywishlist">My Wish List</a></h1>
                            <a id="insa" href="$co"><button id="insc">$user</button></a>
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
                                    margin-bottom: 5em;
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
                            </style>
                            </body>
                        END
                );
                return $rs;
            }
}