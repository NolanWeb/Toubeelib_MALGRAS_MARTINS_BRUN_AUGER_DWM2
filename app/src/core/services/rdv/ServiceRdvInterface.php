<?php

namespace toubeelib\core\services\rdv;

use toubeelib\core\dto\rdv\RdvDTO;

interface ServiceRdvInterface
{

    public function getAllRdvs(): array;
    public function createRdv(RdvDTO $rdvDTO): RdvDTO;
    public function updateRdv(RdvDTO $rdvDTO): RdvDTO;
    public function deleteRdv(string $rdvID): RdvDTO;


}