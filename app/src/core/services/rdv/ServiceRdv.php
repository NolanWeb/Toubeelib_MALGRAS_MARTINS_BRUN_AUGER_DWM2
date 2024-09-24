<?php

namespace toubeelib\core\services\rdv;

use toubeelib\core\dto\rdv\RdvDTO;
use toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\core\repositoryInterfaces\RdvRepositoryInterfaces;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class ServiceRdv implements ServiceRdvInterface
{
    private RdvRepositoryInterfaces $rdvRepository;
    private ServicePraticienInterface $praticienService;

    public function __construct(RdvRepositoryInterfaces $rdvRepository, ServicePraticienInterface $praticienService)
    {
        $this->rdvRepository = $rdvRepository;
        $this->praticienService = $praticienService;
    }

    /**
     * @throws ServiceRdvInvalidDataException
     */
    public function consultRdv(string $rdvID): RdvDTO
    {
        try {
            $rdv = $this->rdvRepository->getRdvById($rdvID);
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServiceRdvInvalidDataException('Invalid Rdv ID');
        }

        $praticien = $this->praticienService->getPraticienById($rdv->getPraticienId());

        return new RdvDTO($rdv, $praticien);
    }
}