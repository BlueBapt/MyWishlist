<?php

namespace mywishlist\vue;

use Illuminate\Database\Capsule\Manager as DB;
use mywishlist\model\Item;
use mywishlist\model\Liste as Liste;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VueImageItem
{
    public static function ajouterImage(Request $rq, Response $rs, $args) : Response {
        $rs->getBody()->write(<<<END
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
        END);
        return $rs;
    }

    public static function modifierImage2(Request $rq, Response $rs, $args) : Response {
        $rs->getBody()->write(<<<END
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
        END);
        return $rs;
    }

    public static function acceuil(Request $rq, Response $rs, $args) : Response {
        $rs->getBody()->write(<<<END
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

        END);
        return $rs;
    }
}