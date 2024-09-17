<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):\Slim\App {

    $app->get('/',
        \toubeelib\application\actions\HomeAction::class);
    $app->get('/rdv/{id}',
        \toubeelib\application\actions\GetRdvAction::class);
    $app->post('/rdv/create',
        \toubeelib\application\actions\CreateRdvAction::class);
    $app->put('/rdv/{id}/update',
        \toubeelib\application\actions\UpdateRdvAction::class);

    return $app;
};