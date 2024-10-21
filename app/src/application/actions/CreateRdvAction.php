<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validatable;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\core\dto\rdv\InputRdvDTO;
use toubeelib\core\dto\rdv\RdvDTO;
use toubeelib\core\services\rdv\ServiceRdvInterface;
use toubeelib\core\services\rdv\ServiceRdvInvalidDataException;

class CreateRdvAction extends AbstractAction
{
    protected ServiceRdvInterface $serviceRdv;

    public function __construct(ServiceRdvInterface $serviceRdv)
    {
        $this->serviceRdv = $serviceRdv;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {

        $data = $request->getParsedBody();
        $placeInputValidator = Validator::key('date', Validator::stringType()->notEmpty())
            ->key('duree', Validator::intVal()->notEmpty())
            ->key('praticienId', Validator::stringType()->notEmpty())
            ->key('patientId', Validator::stringType()->notEmpty())
            ->key('specialite', Validator::stringType()->notEmpty())
            ->key('lieu', Validator::stringType()->notEmpty())
            ->key('type', Validator::stringType()->notEmpty());
        try {
            $placeInputValidator->assert($data);
        } catch (ValidationException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        }
        if (filter_var($data["date"], FILTER_SANITIZE_SPECIAL_CHARS) !== $data["date"]) {
            throw new HttpBadRequestException($request, 'Invalid date');
        }
        if (filter_var($data["praticienId"], FILTER_SANITIZE_SPECIAL_CHARS) !== $data["praticienId"]) {
            throw new HttpBadRequestException($request, 'Invalid praticien_id');
        }
        if (filter_var($data["patientId"], FILTER_SANITIZE_SPECIAL_CHARS) !== $data["patientId"]) {
            throw new HttpBadRequestException($request, 'Invalid patient_id');
        }
        if (filter_var($data["specialite"], FILTER_SANITIZE_SPECIAL_CHARS) !== $data["specialite"]) {
            throw new HttpBadRequestException($request, 'Invalid specialite');
        }
        if (filter_var($data["lieu"], FILTER_SANITIZE_SPECIAL_CHARS) !== $data["lieu"]) {
            throw new HttpBadRequestException($request, 'Invalid lieu');
        }
        if (filter_var($data["type"], FILTER_SANITIZE_SPECIAL_CHARS) !== $data["type"]) {
            throw new HttpBadRequestException($request, 'Invalid type');
        }

        $data = new InputRdvDTO(
            new \DateTimeImmutable($data['date']),
            $data['duree'],
            $data['praticienId'],
            $data['patientId'],
            $data['specialite'],
            $data['lieu'],
            $data['type']
        );
        $rdv = $this->serviceRdv->createRdv($data);

        $response = [
            "type" => "resource",
            "locale" => "fr-FR",
            "rdv" => $rdv,
            "links" => [
                "self" => "/rdvs/" . $rdv->getID(),
                "update" => "/rdvs/" . $rdv->getID(),
                "delete" => "/rdvs/" . $rdv->getID()
            ]
        ];
        return JsonRenderer::render($response, 201, $response);
    } catch (ServiceRdvInvalidDataException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        }
    }
}