<?php

namespace toubeelib\core\services\rdv;

use PhpParser\Node\Expr\Cast\Object_;
use Ramsey\Uuid\Uuid;
use toubeelib\core\domain\entities\rdv\Rdv;
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

        return new RdvDTO($rdv);
    }

    public function createRdv($rdv): RdvDTO
    {
        $newRdv = new Rdv($rdv['date'], $rdv['duree'], $rdv['praticienId'], $rdv['patientId'], $rdv['specialite']);
        $newRdv->setID(Uuid::uuid4()->toString());

        $this->rdvRepository->save($newRdv);

        $dto = new RdvDTO($newRdv);
        return $dto;
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


    public function updateRdv($rdv): RdvDTO
    {
        if (isset($rdv['specialite'])) {
            $this->rdvRepository->getRdvById($rdv['ID'])->modifierSpecialite($rdv['specialite']);
        } else if (isset($rdv['patientId'])) {
            $this->rdvRepository->getRdvById($rdv['ID'])->modifierPatientRDV($rdv['patientId']);
        } else {
            throw new ServiceRdvInvalidDataException('Invalid Rdv data');
        }
        return new RdvDTO($this->rdvRepository->getRdvById($rdv['ID']));
    }

    public function getRdvsByPraticienId(string $praticienId): array
    {
        $rdvs = $this->rdvRepository->getRdvsByPraticienId($praticienId);
        $rdvDTOs = [];
        foreach ($rdvs as $rdv) {
            $praticien = $this->praticienService->getPraticienById($rdv->getPraticienId());
            $rdvDTOs[] = new RdvDTO($rdv, $praticien);
        }
        return $rdvDTOs;
    }
}