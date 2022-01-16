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
    public static function formulaire(Request $rq, Response $rs, $args) : Response {
        $rs->getBody()->write(<<<END
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <title>MyWishList</title>
            </head>
            <body>
                <form id="formulaire" method="post">
                    <fieldset id="field">
                        <legend id="ajt">Ajout d'item dans la liste.</legend>
                        <p class="token">
                            <label for="nom">Entrer le token : </label>
                            <input type="text" name="token" id="token" placeholder="token" required>
                        </p>
                        <p class="nom">
                            <label for="nom">Entrer le nom : </label>
                            <input type="text" name="nomItem" id="nom" placeholder="NOM *" required>
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
                        margin-top: 9%;
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
}