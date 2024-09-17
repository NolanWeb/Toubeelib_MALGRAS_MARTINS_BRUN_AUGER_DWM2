<?php

namespace toubeelib\core\services\rdv;

use toubeelib\core\dto\rdv\RdvDTO;
use toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\core\repositoryInterfaces\RdvRepositoryInterfaces;

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
    public function consulterRdv(int $rdvID): RdvDTO
    {
        try {
            $rdvID = $this->rdvRepository->consulterRdv($rdvID);
        } catch (ServiceRdvInvalidDataException $e) {
            throw new ServiceRdvInvalidDataException('Invalid Rdv ID');
        }

        $praticien = $this->praticienService->getPraticienById($rdvID->getPraticienId());

        return new RdvDTO($rdvID, $praticien);

    }
}