<?php
namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\core\services\praticien\ServicePraticienInvalidDataException;

class GetPraticienAction extends AbstractAction
{
    protected ServicePraticienInterface $servicepraticien;

    public function __construct(ServicePraticienInterface $servicepraticien)
    {
        $this->servicepraticien = $servicepraticien;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $praticien_dto = $this->servicepraticien->consultPraticien((string)$args['id']);
        } catch (ServicePraticienInvalidDataException $e) {
            throw new HttpNotFoundException($request, $e->getMessage(). ' : '.$args['id']);
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
            }, [$praticien_dto]),
            'links' => [
                'futur link wip'
            ]
        ];


        return JsonRenderer::render($response, 200, $data);
    }
}