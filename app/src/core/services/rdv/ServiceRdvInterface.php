<?php

namespace toubeelib\core\services\rdv;

use toubeelib\core\dto\practicien\PraticienDTO;
use toubeelib\core\dto\rdv\RdvDTO;

interface ServiceRdvInterface
{

    public function consultRdv(string $rdvID): RdvDTO;


}