<?php

namespace mywishlist\vue;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VueAcceuil
{
    public static function afficherFormulaire(Request $rq, Response $rs, $args):Response{
        $rs->getBody()->write(<<<END
                    <body>
                        <div class="container">
                            <div class="liste">
                                <p>hello</p>
                            </div>
                        </div>
                    </body>
                END);
        return $rs;
    }
}