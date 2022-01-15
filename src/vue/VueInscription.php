<?php

namespace mywishlist\vue;

use Exception;
use Illuminate\Database\Capsule\Manager as DB;
use mywishlist\model\Authentification;
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
                            <form id="formulaire" method="post" >
                                <div class="insP">
                                    <div class="insL">
                                        <label id="inL" for="nom">Veuillez saisir un login : *</label>
                                        <label id="inL" for="nom">Veuillez saisir votre mail : *</label>
                                        <label id="inL" for="nom">Entrer un mot de passe : *</label>
                                        <label id="inL" for="nom">Saisir à nouveau votre mot de passe : *</label>
                                    </div>
                                    <div class="insI">
                                        <input id="inI" type="text" name="login" id="login" placeholder="login" required>
                                        <input id="inI" type="email" name="mail" id="mail" placeholder="personnal@example.com" required>
                                        <input id="inI" type="password" name="mdp" id="mdp" placeholder="mot de passe" required>
                                        <input id="inI" type="password" name="mdp" id="mdp" placeholder="mot de passe" required>
                                    </div>
                                </div>
                                <input type="submit" value="Valider" id="bt">
                            </form>
                        </div>
                        <div class="co">
                            <h1 id="insh"><u>CONNEXION :</u></h1>
                            <form id="formulaire" method="post">
                                <div class="coP">
                                    <div class="coL">
                                        <label for="nom">Veuillez saisir votre login : *</label>
                                        <label for="nom">Entrer votre mot de passe : *</label>
                                    </div>
                                    <div class="coI">
                                        <input type="text" name="loginCO" id="login" placeholder="login" required>
                                        <input type="password" name="mdpCO" id="mdp" placeholder="mot de passe" required>
                                    </div>
                                </div>
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