<?php

namespace toubeelib\core\domain\entities\rdv;

use DateTimeImmutable;
use PhpParser\Node\Scalar\String_;
use toubeelib\core\domain\entities\Entity;
use toubeelib\core\domain\entities\patient\Patient;
use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\domain\entities\praticien\Specialite;
use toubeelib\core\dto\rdv\RdvDTO;

class Rdv extends Entity
{
    protected ?string $ID;
    protected \DateTimeInterface $date;
    protected int $duree;
    protected string $praticienId;
    protected string $patientId;
    protected string $specialite;
    protected string $statut;
    protected string $lieu;
    protected string $type;

    public function __construct(\DateTimeInterface $date, int $duree, string $praticienId, string $patientId, string $specialite, string $lieu, string $type)
    {
        $this->date = $date;
        $this->duree = $duree;
        $this->praticienId = $praticienId;
        $this->patientId = $patientId;
        $this->specialite = $specialite;
        $this->lieu = $lieu;
        $this->type = $type;
        $this->statut = "prévu";
    }

    public function deleteRDV (): void
    {
        $this->statut = "annulé";
    }

    public function modifierPatientRDV (Patient $patient)
    {
        $this->patientId = $patient;
    }

    public function modifierSpecialite($specialite)
    {
        $this->specialite = $specialite;
    }

    public function honorerRDV ()
    {
        $this->statut = "honoré";
    }
    public function payerRDV ()
    {
        $this->statut = "payé";
    }
    public function nePasHonorerRDV ()
    {
        $this->statut = "non honoré";
    }

    public function getID(): string
    {
        return $this->ID;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getDuree(): int
    {
        return $this->duree;
    }

    public function getPraticienId(): string
    {
        return $this->praticienId;
    }

    public function getPatientId(): string
    {
        return $this->patientId;
    }

    public function getSpecialite(): String
    {
        return $this->specialite;
    }

    public function getLieu(): string
    {
        return $this->lieu;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function toDTO(): RdvDTO
    {
        return new RdvDTO($this);
    }
}