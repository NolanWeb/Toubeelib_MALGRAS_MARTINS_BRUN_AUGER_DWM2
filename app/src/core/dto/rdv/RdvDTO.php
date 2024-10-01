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


    public function __construct(Rdv $rdv)
    {
        $this->ID = $rdv->getID();
        $this->date = $rdv->date;
        $this->praticienId = $rdv->praticienId;
        $this->patientId = $rdv->patientId;
        $this->statut = $rdv->statut;
    }

public function jsonSerialize(): array
{
    return [
        'ID' => $this->ID,
        'date' => $this->date->format('Y-m-d H:i'),
        'praticienId' => $this->praticienId,
        'patientId' => $this->patientId,
        'statut' => $this->statut
    ];

}
}