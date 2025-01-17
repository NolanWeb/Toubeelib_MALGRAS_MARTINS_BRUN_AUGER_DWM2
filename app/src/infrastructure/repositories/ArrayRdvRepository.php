<?php

namespace toubeelib\infrastructure\repositories;

use Ramsey\Uuid\Uuid;
use toubeelib\core\domain\entities\rdv\Rdv;
use toubeelib\core\repositoryInterfaces\RdvRepositoryInterfaces;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;


class ArrayRdvRepository implements RdvRepositoryInterfaces
{
    private array $rdvs = [];

    public function __construct() {
            $r1 = new Rdv(\DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 09:00'), 30, 'p1', 'a', 'Test');
            $r1->setID('r1');
            $r2 = new Rdv(\DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 09:00'), 30, 'p2', 'b', 'Test');
            $r2->setID('r2');
            $r3 = new Rdv(\DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 09:00'), 30,'p3', 'c', 'Test');
            $r3->setID('r3');

        $this->rdvs  = ['r1'=> $r1, 'r2'=>$r2, 'r3'=> $r3 ];
    }

    public function getAllRdvs(): array
    {
        return array_values($this->rdvs);
    }

    public function getRdvsByPraticienId(string $praticienId): array
    {
        return array_filter($this->rdvs, function (Rdv $rdv) use ($praticienId) {
            return $rdv->getPraticienId() === $praticienId;
        });
    }

    public function getRdvById(string $id): Rdv
    {
        if (!isset($this->rdvs[$id])) {
            throw new RepositoryEntityNotFoundException("Rendez-vous not found");
        }
        return $this->rdvs[$id];
    }

    public function save(Rdv $rdv): string
    {
        $ID = $rdv->getID();
        $this->rdvs[$ID] = $rdv;
        return $ID;
    }

    /**
     * @throws RepositoryEntityNotFoundException
     */
    public function update(Rdv $rdv): void
    {
        $id = $rdv->getID();
        if (!isset($this->rdvs[$id])) {
            throw new RepositoryEntityNotFoundException("Rendez-vous not found");
        }
        $this->rdvs[$id] = $rdv;
    }

    public function delete(string $id): void
    {
        if (!isset($this->rdvs[$id])) {
            throw new RepositoryEntityNotFoundException("Rendez-vous not found");
        }
        unset($this->rdvs[$id]);
    }

    /**
     * @throws RepositoryEntityNotFoundException
     */
    public function consultRdv(string $id): Rdv
    {
        if (!isset($this->rdvs[$id])) {
            throw new RepositoryEntityNotFoundException("Rendez-vous not found");
        }
        return $this->rdvs[$id];
    }

    /**
     * @throws RepositoryEntityNotFoundException
     */
    public function deleteRdv(string $id): Rdv
    {
        if (!isset($this->rdvs[$id])) {
            throw new RepositoryEntityNotFoundException("Rendez-vous not found");
        }
        $this->rdvs[$id]->deleteRDV();
        return $this->rdvs[$id];
    }

    public function getRdvsByPraticienAndWeek(string $praticienId, string $week): array
    {
        $rdvs = [];
        foreach ($this->rdvs as $rdv) {
            if ($rdv->getPraticienId() === $praticienId) {
                if ($rdv->getDate()->format('W') === $week) {
                    $rdvs[] = $rdv;
                }
            }
        }
        return $rdvs;
    }

    public function getRdvsByPatientId(string $patientId): array
    {
        $result = [];
        foreach ($this->rdvs as $rdv) {
            if ($rdv->getPatientId() === $patientId) {
                $result[] = $rdv;
            }
        }
        if (empty($result)) {
            throw new RepositoryEntityNotFoundException("No rdvs found for patient $patientId");
        }
        return $result;
    }
}