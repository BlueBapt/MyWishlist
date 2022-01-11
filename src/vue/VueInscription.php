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
        $db = new DB();
        $db->addConnection( ['driver'=>'mysql','host'=>'localhost','database'=>'mywishlist',
            'username'=>'wishmaster','password'=>'TropFort54','charset'=>'utf8','collation'=>'utf8_unicode_ci',
            'prefix'=>''] );
        $db->setAsGlobal();
        $db->bootEloquent();

        if(isset($_POST["mail"]) ){
            try{
                Authentification::creerUtilisateur($_POST["login"],$_POST["mdp"],$_POST["mail"],1);
                Authentification::authentification($_POST["login"],$_POST["mdp"]);
            }catch(Exception $e){
                $rs->getBody()->write(<<<END
<html>
    <h3>Nom d'utilisateur déjà existant!</h3>
</html>

END);
            }
        }else if(isset($_POST["loginCO"])){
            try{
                Authentification::authentification($_POST["loginCO"],$_POST["mdpCO"]);
            }catch(Exception $e){
                $rs->getBody()->write(<<<END
<html>
    <h3>Mauvais identifiant ou mot de passe</h3>
</html>

END);
            }
        }
        //action="inscription" method="post"
        $user = "inscription/connexion";
        if (isset($_SESSION["user"]))
            $user = $_SESSION["user"];

        $rs->getBody()->write(<<<END
            <html>
                <head>
                    <meta charset="utf-8" />
                    <title>My wish list</title>
                    <link rel="stylesheet" href="css/inscription.css">
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
                            <a id="insa" href="https://127.0.0.1/mywishlist/inscription"><button id="insc">$user</button></a>
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