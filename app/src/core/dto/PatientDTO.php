<?php

namespace toubeelib\core\dto;

use toubeelib\core\domain\entities\patient\Patient;
use toubeelib\core\dto\DTO;

class PatientDTO extends DTO
{
    protected string $ID;
    protected string $nom;
    protected string $prenom;
    protected string $adresse;
    protected string $tel;
    protected string $mail;
    protected string $dossierMedical;


    public function __construct(Patient $p)
    {
        $this->ID = $p->getID();
        $this->nom = $p->nom;
        $this->prenom = $p->prenom;
        $this->adresse = $p->adresse;
        $this->tel = $p->tel;
        $this->mail = $p->mail;
        $this->dossierMedical = $p->dossierMedical;
    }


}