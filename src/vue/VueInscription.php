<?php

namespace mywishlist\vue;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VueInscription
{
    public static function afficherFormulaire(Request $rq, Response $rs, $args):Response{
        $rs->getBody()->write(<<<END
            <html>
                <head>
                    <meta charset="utf-8" />
                    <title>My wish list</title>
                    <link rel="stylesheet" href="css/inscription.css">
                </head>
                <body>
                    <div class="container">
                        <div class="ins">
                            <h1 id="insh"><u>INSCRIPTION :</u></h1>
                            <form id="formulaire">
                                <p class="token">
                                    <label for="nom">Veuillez saisir un login : *</label>
                                    <input type="text" name="login" id="login" placeholder="login" required>
                                </p>
                                <p class="nom">
                                    <label for="nom">Entrer un mot de passe : *</label>
                                    <input type="password" name="mdp" id="mdp" placeholder="mot de passe" required>
                                </p>
                                <p class="nom">
                                    <label for="nom">Saisir à nouveau votre mot de passe : *</label>
                                    <input type="password" name="mdp" id="mdp" placeholder="mot de passe" required>
                                </p>
                                <input type="submit" value="Valider" id="bt">
                            </form>
                        </div>
                        <hr>
                        <div class="co">
                            <h1 id="insh"><u>CONNEXION :</u></h1>
                            <form id="formulaire">
                                <p class="token">
                                    <label for="nom">Veuillez saisir un login : *</label>
                                    <input type="text" name="login" id="login" placeholder="login" required>
                                </p>
                                <p class="nom">
                                    <label for="nom">Entrer un mot de passe : *</label>
                                    <input type="password" name="mdp" id="mdp" placeholder="mot de passe" required>
                                </p>
                                <input type="submit" value="Valider" id="bt">
                            </form>
                        </div>
                    </div>
                </body>
            </html>
        END);
        return $rs;
    }
}