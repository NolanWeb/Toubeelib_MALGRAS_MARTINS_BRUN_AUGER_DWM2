<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):\Slim\App {

    $app->get('/',
        \toubeelib\application\actions\HomeAction::class);
    $app->post('/api/commandes/add',
        \toubeelib\application\actions\CreateCommandeAction::class);
    $app->post('/api/commandes/{commandeId}/items',
        \toubeelib\application\actions\AddItemToCommandeAction::class);
    $app->put('/api/commandes/{commandeId}/client',
        \toubeelib\application\actions\SetClientForCommandeAction::class);
    $app->get('/api/clients/{clientId}/commandes',
        \toubeelib\application\actions\ListCommandesForClientAction::class);
    $app->get('/api/commandes/{commandeId}/items',
        \toubeelib\application\actions\ListItemsForCommandeAction::class);
    $app->get('/commandes/{id}',
        \toubeelib\application\actions\GetCommandeAction::class);
    $app->put('/commande/set-paiement/{id}',
        \toubeelib\application\actions\SetPaiementAction::class);
    $app->get('/commande/get_client/{id}',
        \toubeelib\application\actions\GetClientForCommandeAction::class);

    return $app;
};