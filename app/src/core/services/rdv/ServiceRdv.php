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

    public function getAllRdvs(): array
    {
        $all_rdvs = [];
        foreach ($this->rdvRepository->getAllRdvs() as $rdv) {
            $praticien = $this->praticienService->getPraticienById($rdv->getPraticienId());
            $all_rdvs[] = new RdvDTO($rdv, $praticien);
        }
        return $all_rdvs;
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

    /**
     * @throws ServiceRdvInvalidDataException
     */
    public function deleteRdv(string $rdvID): RdvDTO
    {
        try {
            $rdv = $this->rdvRepository->getRdvById($rdvID);
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServiceRdvInvalidDataException('Invalid Rdv ID');
        }
        $rdv->deleteRDV();
        return new RdvDTO($rdv);
    }

    public function createRdv(RdvDTO $rdvDTO): RdvDTO
    {
        // TODO: Implement createRdv() method.
    }

    public function updateRdv(RdvDTO $rdvDTO): RdvDTO
    {
        // TODO: Implement updateRdv() method.
    }
}