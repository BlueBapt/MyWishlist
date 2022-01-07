<?php

namespace mywishlist\vue;

use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VueInscription
{
    public static function afficherFormulaire(Request $rq, Response $rs, $args):Response{
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();

        if(isset($_POST["login"]) ){
            echo($_POST["login"]);
        }
        //action="inscription" method="post"

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
                            <form id="formulaire" >
                                <p class="login">
                                    <label for="nom">Veuillez saisir un login : *</label>
                                    <input type="text" name="login" id="login" placeholder="login" required>
                                </p>
                                <p class="mail">
                                    <label for="nom">Veuillez saisir votre mail : *</label>
                                    <input type="email" name="mail" id="mail" placeholder="personnal@example.com" required>
                                </p>
                                <p class="mdp">
                                    <label for="nom">Entrer un mot de passe : *</label>
                                    <input type="password" name="mdp" id="mdp" placeholder="mot de passe" required>
                                </p>
                                <p class="mdp">
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
                                <p class="login">
                                    <label for="nom">Veuillez saisir un login : *</label>
                                    <input type="text" name="loginCO" id="login" placeholder="login" required>
                                </p>
                                <p class="mdp">
                                    <label for="nom">Entrer un mot de passe : *</label>
                                    <input type="password" name="mdpCO" id="mdp" placeholder="mot de passe" required>
                                </p>
                                <input type="submit" value="Valider" id="bt">
                            </form>
                        </div>
                    </div>
                </body>
            </html>
        END);
        if (isset($_GET["login"]) && isset($_GET["mail"]) && isset($_GET["mdp"])) {
            $login = $_GET["login"];
            $mail = $_GET["mail"];
            $mdp = $_GET["mdp"];

            $headers = 'From: MyWishList' . "\r\n" .
                'Content-type: text/html; charset=iso-8859-1'.
                'MIME-Version: 1.0'.
                'X-Mailer: PHP/' . phpversion();
            $message = "<html lang='fr'>
                        <body>
                            <div style='width: 50%; margin-left: 25%; background-color: gray;'>
                                <div style='width: 100%; background-color: aqua; color: white; text-align: center;'>
                                    <h1>MyWishList</h1>
                                </div>
                                <div style='color: white; font-size: x-large;'>
                                    <p>Merci pour votre inscription</p>
                                    <br>
                                    <p>Voici quelque informations sur votre inscription :</p>
                                    <ul>
                                        <li>Votre login : $login</li>
                                        <li>Voici le lien du site : https://127.0.0.1/mywishlist</li>
                                    </ul>
                                </div>
                            </div>
                        </body> 
                        </html>";

            $envoieMail = mail($mail, "Incription à MyWishList", $message, $headers);
            if ($envoieMail)
                echo "message evoyé";
            //rocketleaguetd@gmail.com
        }
        return $rs;
    }
}