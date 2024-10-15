<?php

namespace toubeelib\core\services\praticien;

use toubeelib\core\dto\practicien\InputPraticienDTO;
use toubeelib\core\dto\practicien\PraticienDTO;
use toubeelib\core\dto\practicien\SpecialiteDTO;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\core\domain\entities\praticien\Praticien;
use Ramsey\Uuid\Uuid;

class ServicePraticien implements ServicePraticienInterface
{
    private PraticienRepositoryInterface $praticienRepository;

    public function __construct(PraticienRepositoryInterface $praticienRepository)
    {
        $this->praticienRepository = $praticienRepository;
    }

    public function getPraticienById(string $id): PraticienDTO
    {
        try {
            $praticien = $this->praticienRepository->getPraticienById($id);
            return new PraticienDTO($praticien);
        } catch(RepositoryEntityNotFoundException $e) {
            throw new ServicePraticienInvalidDataException('invalid Praticien ID');
        }
    }

    public function getSpecialiteById(string $id): SpecialiteDTO
    {
        try {
            $specialite = $this->praticienRepository->getSpecialiteById($id);
            return $specialite->toDTO();
        } catch(RepositoryEntityNotFoundException $e) {
            throw new ServicePraticienInvalidDataException('invalid Specialite ID');
        }
    }

    public function getAllPraticiens(): array
    {
        $praticiens = $this->praticienRepository->getAllPraticiens();
        return array_map(fn($praticien) => new PraticienDTO($praticien), $praticiens);
    }

    public function createPraticien(InputPraticienDTO $inputPraticienDTO): PraticienDTO
    {
        $praticien = new Praticien(
            $inputPraticienDTO->nom,
            $inputPraticienDTO->prenom,
            $inputPraticienDTO->adresse,
            $inputPraticienDTO->tel
        );

        $this->praticienRepository->createPraticien($praticien);

        return new PraticienDTO($praticien);
    }


    public function consultPraticien(string $praticienID): PraticienDTO
    {
        try {
            $praticien = $this->praticienRepository->getPraticienById($praticienID);
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServicePraticienInvalidDataException('Invalid praticien ID');
        }

        return new PraticienDTO($praticien);
    }
}