<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\core\services\rdv\ServiceRdvInterface;

class UpdateRdvAction extends AbstractAction
{
    protected ServiceRdvInterface $serviceRdv;
    public function __construct(ServiceRdvInterface $serviceRdv)
    {
        $this->serviceRdv = $serviceRdv;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();

        $data['date'] = \DateTimeImmutable::createFromFormat('Y-m-d H:i', $data['date']);
        
        $rdv = $this->serviceRdv->updateRdv($data);

        $response->getBody()->write(json_encode($rdv->jsonSerialize()));

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Location', '/rdvs/'.$rdv->getID());
    }
}
