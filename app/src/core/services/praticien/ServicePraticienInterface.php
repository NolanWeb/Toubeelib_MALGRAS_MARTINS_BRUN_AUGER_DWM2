<?php

namespace toubeelib\core\services\praticien;

use toubeelib\core\dto\practicien\InputPraticienDTO;
use toubeelib\core\dto\practicien\PraticienDTO;
use toubeelib\core\dto\practicien\SpecialiteDTO;

interface ServicePraticienInterface
{

    public function createPraticien(InputPraticienDTO $p): PraticienDTO;
    public function getPraticienById(string $id): PraticienDTO;
    public function getSpecialiteById(string $id): SpecialiteDTO;


}