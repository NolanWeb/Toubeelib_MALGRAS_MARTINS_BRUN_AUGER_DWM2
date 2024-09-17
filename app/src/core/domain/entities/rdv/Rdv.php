<?php

namespace toubeelib\core\domain\entities\rdv;

use DateTimeImmutable;
use toubeelib\core\domain\entities\Entity;
use toubeelib\core\domain\entities\patient\Patient;
use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\dto\rdv\RdvDTO;

class Rdv extends Entity
{
    protected ?string $ID;
    protected DateTimeImmutable $date;
    protected int $duree;
    protected Praticien $praticien;
    protected Patient $patient;
    protected string $specialite;
    protected string $statut;

    public function __construct(DateTimeImmutable $date, int $duree, Praticien $praticien, Patient $patient, string $specialite)
    {
        $this->date = $date;
        $this->duree = $duree;
        $this->praticien = $praticien;
        $this->patient = $patient;
        $this->specialite = $specialite;
        $this->statut = "prévu";
    }

    public function annulerRDV ()
    {
        $this->statut = "annulé";
    }

    public function modifierPatientRDV (Patient $patient)
    {
        $this->patient = $patient;
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

    public function getID(): ?string
    {
        return $this->ID;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getDuree(): int
    {
        return $this->duree;
    }

    public function getPraticien(): Praticien
    {
        return $this->praticien;
    }

    public function getPatient(): Patient
    {
        return $this->patient;
    }

    public function getSpecialite(): string
    {
        return $this->specialite;
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