<?php

namespace mywishlist\vue;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'vendor/autoload.php';

class VueAjoutItem
{
    public static function afficherFormulaire(Request $rq, Response $rs, $args):Response{
        if(isset($_GET["description"]) && isset($_GET["nom"]) && isset($_GET["tarif"])){
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
        }
        $rs->getBody()->write(<<<END
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <title>MyWishList</title>
            </head>
            <body>
                <form class="formulaire">
                    <fieldset>
                        <legend id="ajt">Ajout d'item dans la liste.</legend>
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
                        <input type="submit" value="Valider" id="bt">
                    </fieldset>
                </form>

                <style>
                    body{
                    background-color: lightgray;
                    background-size: cover;
                }
            
                form{
                    width: 50%;
                    grid-column: 2;
                    background-color: rgb(22, 31, 41);
                    border: .3em ridge white;
                    margin-left: 25%;
                    height: 12em;
                }
            
                form > fieldset > p{
                    color: white;
                    margin-bottom: 1.1em;
                }
            
                form > fieldset{
                    height: calc(100% - 1.5em);
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
            
                #bt:hover{
                    border-radius: .1em;
                    transform: scale(1.02);
                }
                </style>
            </body>
            </html>
            END
        );
        return $rs;
    }
}