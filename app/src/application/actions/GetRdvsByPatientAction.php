<?php
namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\core\services\rdv\ServiceRdvInterface;
use toubeelib\core\services\rdv\ServiceRdvInvalidDataException;

class GetRdvsByPatientAction extends AbstractAction
{
    protected ServiceRdvInterface $serviceRdv;

    public function __construct(ServiceRdvInterface $serviceRdv)
    {
        $this->serviceRdv = $serviceRdv;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $rdvs = $this->serviceRdv->getRdvsByPatientId((string)$args['id']);
        } catch (ServiceRdvInvalidDataException $e) {
            throw new HttpNotFoundException($request, $e->getMessage() . ' : ' . $args['id']);
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $data = [
            'rdvs' => array_map(function($rdv) {
                return [
                    'id' => $rdv->getId(),
                    'date' => $rdv->getDate()->format('Y-m-d H:i'),
                    'praticienId' => $rdv->getPraticienId(),
                    'patientId' => $rdv->getPatientId(),
                ];
            }, $rdvs),
            'links' => [
                'self' => ['href' => $routeParser->urlFor('getRdvsByPatient', ['id' => $args['id']])],
            ]
        ];

        return JsonRenderer::render($response, 200, $data);
    }
}