<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\core\services\rdv\ServiceRdvInterface;
use toubeelib\core\services\rdv\ServiceRdvInvalidDataException;
use toubeelib\infrastructure\repositories\ArrayRdvRepository;

class GetRdvAction extends AbstractAction
{
    protected ServiceRdvInterface $serviceRdv;

    public function __construct(ServiceRdvInterface $serviceRdv)
    {
        $this->serviceRdv = $serviceRdv;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $rdv_dto = $this->serviceRdv->consultRdv((string)$args['id']);
        } catch (ServiceRdvInvalidDataException $e) {
            throw new HttpNotFoundException($request, $e->getMessage(). ' : '.$args['id']);
        }
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $data = [
            'rdv' => $rdv_dto,
            'links' => [
                'self' => ['href' => $routeParser->urlFor('getRdv', ['id' => $rdv_dto->ID])],
                'update' => ['href' => $routeParser->urlFor('updateRdv', ['id' => $rdv_dto->ID])]
            ]
        ];
        var_dump($data);
        return JsonRenderer::render($response, 200, $data);
    }
}