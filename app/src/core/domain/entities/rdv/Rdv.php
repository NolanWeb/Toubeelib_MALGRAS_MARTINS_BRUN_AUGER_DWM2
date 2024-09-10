<?php

namespace toubeelib\core\domain\entities\rdv;

use DateTimeImmutable;
use toubeelib\core\domain\entities\Entity;
use toubeelib\core\domain\entities\patient\Patient;
use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\dto\RdvDTO;

class Rdv extends Entity
{
    protected ?string $ID;
    protected DateTimeImmutable $date;
    protected int $duree;
    protected Praticien $praticien;
    protected Patient $patient;
    protected string $statut;

    public function __construct(DateTimeImmutable $date, int $duree, Praticien $praticien, Patient $patient, string $statut)
    {
        $this->date = $date;
        $this->duree = $duree;
        $this->praticien = $praticien;
        $this->patient = $patient;
        $this->statut = $statut;
    }



    public function toDTO(): RdvDTO
    {
        return new RdvDTO($this);
    }
}