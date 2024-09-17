<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\infrastructure\repositories\ArrayRdvRepository;

class GetRdvAction extends AbstractAction
{
    private ArrayRdvRepository $rdvRepository;
    private JsonRenderer $renderer;

    public function __construct(ArrayRdvRepository $rdvRepository, JsonRenderer $renderer)
    {
        $this->rdvRepository = $rdvRepository;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $rdv = $this->rdvRepository->getRdvById($args['id']);
        if (is_null($rdv)) {
            return $this->renderer->render($rs, 404, ['error' => 'Rendez-vous not found']);
        }

        $data = [
            'id' => $rdv->getId(),
            'date' => $rdv->getDate(),
            'links' => [
                'self' => '/rdvs/' . $rdv->getId(),
                'praticien' => '/praticiens/' . $rdv->getPraticienId(),
                'patient' => '/patients/' . $rdv->getPatientId(),
            ],
        ];

        return $this->renderer->render($rs, 200, $data);
    }
}