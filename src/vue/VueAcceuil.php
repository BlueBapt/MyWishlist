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
                        <link rel="stylesheet" href="css/acceuil.css">
                        </head>
                        <body>
                            <div class="page">
                                <div class="title">
                                    <h1>My Wish List</h1>
                                    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" id="rick"><img src="img/legend.png" width="200em"></a>
                                    <a id="insa" href="https://127.0.0.1/mywishlist/inscription"><button id="ins">inscription/connexion</button></a>
                                </div>
                                <div class="menu" id="menu">
                                    <div class="liste" id="liste">
                                        <a href="http://127.0.0.1/mywishlist/creer/liste">Ajouter une liste</a>
                                        <a href="">Afficher une liste</a>
                                        <a href="">Modifier une liste</a>
                                        <a href="">Partager une liste</a>
                                    </div>
                                    <div class="item" id="item">
                                        <a href="http://127.0.0.1/mywishlist/ajout/item">Ajouter un item</a>
                                        <a href="">Supprimer un item</a>
                                        <a href="">Modifier un item</a>
                                        <a href="">Ajouter une image</a>
                                        <a href="">Modifier une image</a>
                                        <a href="">Supprimer une image</a>
                                    </div>
                                </div>
                                <div class="pres" id="pres">
                                    <div class="presG" id="presG">
                                        <h2>Principe du site</h2>
                                        <p>MyWishList.app est une application en ligne pour créer, partager et gérer des listes de cadeaux. L'application permet à un utilisateur de créer une liste de souhaits à l'occasion d'un événement particulier (anniversaire, fin d'année, mariage, retraite ...) et lui permet de diffuser cette liste de souhaits à un ensemble de personnes concernées. Ces personnes peuvent alors consulter cette liste et s'engager à offrir 1 élément de la liste. Cet élément est alors marqué comme réservé dans cette liste.</p>
                                    </div>
                                    <div class="presL">
                                        <h2>Principe des listes</h2>
                                        <p>Ces fonctionnalités sont réservées à des utilisateurs enregistrés et authentifiés sur l'application.</p>
                                        <p>Un utilisateur enregistré peut donc :</p>
                                        <ol type="1">
                                            <li>créer une nouvelle liste en lui donnant un titre, une description, une date limite de validité.</li>
                                            <li>à tout moment tant que la liste est valide, il peut ajouter des items dans la liste.</li>
                                            <li>un item est caractérisé par un nom, un descriptif textuel et un tarif indicatif. Il peut être accompagné d'une url et éventuellement d'une ou plusieurs images.</li>
                                            <li>il peut partager cette liste : pour cela il demande à l'application de générer une url qu'il diffuse ensuite par ses propres moyens. L'url contient un token unique identifiant la liste.</li>
                                            <li>il peut à tout moment consulter la liste et voir quels sont les items sélectionnés, par contre il ne peut pas voir qui a choisi l'item.</li>
                                            <li>après la date limite de validité, le créateur peut consulter la liste et lire les différents messages associés à chaque cadeau de la liste et laissés par les utilisateurs ayant choisi ce cadeau</li>
                                        </ol>
                                    </div>
                                    <div class="presI">
                                        <h2>Principe des items</h2>
                                        <p>Un destinataire de liste est une personne qui reçoit par mail une url lui permettant de participer à une liste de cadeau. L'url lui permet d'accéder à la liste de cadeaux. Il visualise le titre la description et la date limite de validité de la liste, ainsi que la liste des items. Les items déjà réservés sont indiqués, ainsi que le nom de la personne qui l'a réservé (cette information ne doit pas être fournie au créateur de la liste; on pourra utiliser un cookie pour réaliser ce contrôle).</p>
                                        <ol type="1">
                                            <li>choisir de réserver un item, en précisant son nom,</li>
                                            <li>ajouter un message avec une réservation d'item. Ce message est destiné au destinataire du cadeau</li>
                                            <li>ajouter un message ou un commentaire global destiné à l'ensemble des utilisateurs</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </body>
                    
                END
        );
        return $rs;
    }
}