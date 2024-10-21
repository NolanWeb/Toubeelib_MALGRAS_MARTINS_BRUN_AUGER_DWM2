<?php

namespace toubeelib\core\dto\rdv;

use DateTimeImmutable;
use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\domain\entities\rdv\Rdv;
use toubeelib\core\dto\DTO;

class RdvDTO extends DTO implements \JsonSerializable
{
    protected string $ID;
    protected DateTimeImmutable $date;
    protected string $praticienId;
    protected string $patientId;
    protected string $statut;
    protected string $specialite;
    protected string $lieu;
    protected string $type;


    public function __construct(Rdv $rdv)
    {
        $this->ID = $rdv->getID();
        $this->date = $rdv->date;
        $this->praticienId = $rdv->praticienId;
        $this->patientId = $rdv->patientId;
        $this->statut = $rdv->statut;
        $this->specialite = $rdv->specialite;
        $this->lieu = $rdv->lieu;
        $this->type = $rdv->type;
    }

public function jsonSerialize(): array
{
    return [
        'ID' => $this->ID,
        'date' => $this->date,
        'praticienId' => $this->praticienId,
        'patientId' => $this->patientId,
        'statut' => $this->statut,
        'specialite' => $this->specialite,
        'lieu' => $this->lieu,
        'type' => $this->type
    ];

}
public function getId()
{
    return $this->ID;
}


public function getDate(): DateTimeImmutable
{
    return $this->date;
}

public function getPraticienId(): string
{
    return $this->praticienId;
}

public function getPatientId(): string
{
    return $this->patientId;

}
}