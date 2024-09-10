<?php

namespace toubeelib\core\dto\rdv;

use DateTimeImmutable;
use toubeelib\core\domain\entities\patient\Patient;
use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\domain\entities\rdv\Rdv;
use toubeelib\core\dto\DTO;

class RdvDTO extends DTO
{
    protected string $ID;
    protected DateTimeImmutable $date;
    protected Praticien $praticien;
    protected Patient $patient;
    protected string $statut;


    public function __construct(Rdv $rdv)
    {
        $this->ID = $rdv->getID();
        $this->date = $rdv->date;
        $this->praticien = $rdv->praticien;
        $this->patient = $rdv->patient;
        $this->statut = $rdv->statut;
    }


}