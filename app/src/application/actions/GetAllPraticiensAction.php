<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\core\services\praticien\ServicePraticienInvalidDataException;

class GetAllPraticiensAction extends AbstractAction
{
    protected ServicePraticienInterface $servicePraticien;

    public function __construct(ServicePraticienInterface $servicePraticien)
    {
        $this->servicePraticien = $servicePraticien;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $praticiens = $this->servicePraticien->getAllPraticiens();
        } catch (ServicePraticienInvalidDataException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $data = [
            'praticiens' => array_map(function($praticien) {
                return [
                    'id' => $praticien->ID,
                    'nom' => $praticien->nom,
                    'prenom' => $praticien->prenom,
                    'adresse' => $praticien->adresse,
                    'telephone' => $praticien->tel,
                    'specialite' => $praticien->specialite_label,
                ];
            }, $praticiens),
            'links' => [
                'self' => ['href' => $routeParser->urlFor('getAllPraticiens')],
            ]
        ];

        return JsonRenderer::render($response, 200, $data);
    }
}