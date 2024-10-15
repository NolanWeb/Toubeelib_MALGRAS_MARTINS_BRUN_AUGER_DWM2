<?php

namespace toubeelib\core\services\rdv;

use toubeelib\core\domain\entities\rdv\Rdv;
use toubeelib\core\dto\practicien\PraticienDTO;
use toubeelib\core\dto\rdv\RdvDTO;

interface ServiceRdvInterface
{

    public function consultRdv(string $rdvID): RdvDTO;
    public function createRdv($rdv): RdvDTO;
    public function getAllRdvs(): array;
    public function updateRdv($rdv): RdvDTO;
    public function deleteRdv(string $rdvID): RdvDTO;
    public function getRdvsByPraticienId(string $praticienId): array;
    public function getRdvsByPraticienAndWeek(string $praticienId, string $week): array;

}