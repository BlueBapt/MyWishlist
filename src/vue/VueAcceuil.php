<?php

namespace mywishlist\vue;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VueAcceuil
{
    public static function afficherFormulaire(Request $rq, Response $rs, $args):Response{
        $rs->getBody()->write(<<<END
                    <!DOCTYPE html>
                    <html>
                        <head>
                        <meta charset="utf-8" />
                        <title>My wish list</title>
                        <link rel="stylesheet" href="acceuil.css">
                        </head>
                        <body>
                            <div class="page">
                                <div class="title">
                                    <h1>My Wish List</h1>
                                    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" id="rickroll"><img src="img/legend.png" alt="la legend" width="200em"></a>
                                </div>
                                <div class="menu">
                                    <div class="liste">
                                        <a href="http://127.0.0.1/mywishlist/creer/liste">Ajouter une liste</a>
                                        <a href="">Afficher une liste</a>
                                        <a href="">Modifier une liste</a>
                                        <a href="">Partager une liste</a>
                                    </div>
                                    <div class="item">
                                        <a href="http://127.0.0.1/mywishlist/ajout/item">Ajouter un item</a>
                                        <a href="">Supprimer un item</a>
                                        <a href="">Modifier un item</a>
                                        <a href="">Ajouter une image</a>
                                        <a href="">Modifier une image</a>
                                        <a href="">Supprimer une image</a>
                                    </div>
                                </div>
                            </div>
                        </body>
                    
                END);
        return $rs;
    }
}