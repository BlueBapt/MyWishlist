<?php

namespace mywishlist\vue;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VueAcceuil
{
    public static function afficherFormulaire(Request $rq, Response $rs, $args):Response{
        $rs->getBody()->write(<<<END
                    <body>
                        
                    </body>
                END);
        return $rs;
    }
}