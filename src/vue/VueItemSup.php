<?php

namespace mywishlist\vue;

use Illuminate\Database\Capsule\Manager as DB;
use mywishlist\model\Item;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VueItemSup
{
    public static function acceuil(Request $rq, Response $rs, $args) : Response{
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
                        <legend id='ajt'>Suppression d'un item.</legend>
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
        END
        );
        return $rs;
    }

    public static function verification(Request $rq, Response $rs, $args) : Response {
        $val = null;
        if (isset($_SESSION["name"]))
            $val = $_SESSION["name"];
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
                        <legend id='ajt'>Suppression d'un item.</legend>
                        <p class='nom'>
                            <label for='name'>Etes-vous sûre ? : </label>
                            <div class='radio'>
                                <div>
                                    <p style='margin-right: 1em'>Oui</p>
                                    <input type='radio' name='verif' id='name' value='yes' required>
                                </div>
                                <div>
                                    <p style='margin-right: 1em'>Non</p>
                                    <input type='radio' name='verif' id='name' value='no' required>
                                </div>
                            </div>
                            <input type='hidden' name='$val' id='name' required>
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
                        
                        .radio{
                            display: flex;
                            flex-direction: column; 
                        }
                        .radio>*{
                            display: flex;
                            flex-direction: row;
                            color: white;                           
                        }
                        
                </style>
             
            </body>
            </html>
        END
        );
        return $rs;
    }

    private function form(string $name) : string{
        $val = null;
        if (isset($_SESSION["name"]))
            $val = $_SESSION["name"];
        $acceuil = "";
        $notExist = "
            
        ";
        $existPlus = "
            <div id='error' style='background-color: green;width: 50%; height: 2em; margin-left: 25%;text-align: center; color: white'>
                <p>L'item a été suprimé</p>
            </div>
        ";

        if ($name == "inexist")
            return $notExist;
        elseif ($name == "ep")
            return $existPlus;
        else {
            return "error";
        }
    }
}