<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):\Slim\App {

    $app->get('/',
        \toubeelib\application\actions\HomeAction::class);
    $app->get('/rdvs[/]',
        \toubeelib\application\actions\GetAllRdvsAction::class)
        ->setName('getAllRdvs');

    $app->get('/rdv/{id}[/]',
        \toubeelib\application\actions\GetRdvAction::class)
        ->setName('getRdv');

    $app->post('/rdv/create',
        \toubeelib\application\actions\CreateRdvAction::class);

    $app->patch('/rdv/{id}',
        \toubeelib\application\actions\UpdateRdvAction::class)
        ->setName('updateRdv');
        
    $app->delete('/rdv/{id}',
        \toubeelib\application\actions\DeleteRdvAction::class)
        ->setName('deleteRdv');

        

    return $app;
};