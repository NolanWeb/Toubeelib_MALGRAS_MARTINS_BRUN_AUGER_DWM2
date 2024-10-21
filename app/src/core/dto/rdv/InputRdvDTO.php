<?php

namespace toubeelib\core\dto\rdv;

use toubeelib\core\dto\DTO;

class InputRdvDTO extends DTO
{
    protected \DateTimeInterface $date;
    protected string $duree;
    protected string $praticienId;
    protected string $patientId;
    protected string $specialite;
    protected string $lieu;
    protected string $type;

    public function __construct(\DateTimeInterface $date, string $duree, string $praticienId, string $patientId, string $specialite, string $lieu, string $type) {
        $this->date = $date;
        $this->duree = $duree;
        $this->praticienId = $praticienId;
        $this->patientId = $patientId;
        $this->specialite = $specialite;
        $this->lieu = $lieu;
        $this->type = $type;
    }
}