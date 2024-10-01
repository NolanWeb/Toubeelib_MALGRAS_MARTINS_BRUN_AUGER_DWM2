<?php

namespace toubeelib\core\dto\practicien;

use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\dto\DTO;

class PraticienDTO extends DTO
{
    protected ?string $ID;
    protected string $nom;
    protected string $prenom;
    protected string $adresse;
    protected string $tel;
    protected string $specialite_label = ''; // string vide par default

    public function __construct(Praticien $praticien)
    {
        $this->ID = $praticien->getID();
        $this->nom = $praticien->nom;
        $this->prenom = $praticien->prenom;
        $this->adresse = $praticien->adresse;
        $this->tel = $praticien->tel;

        // au cas ou pas de specialite
        if ($praticien->specialite !== null) {
            $this->specialite_label = $praticien->specialite->label;
        }
    }
}
