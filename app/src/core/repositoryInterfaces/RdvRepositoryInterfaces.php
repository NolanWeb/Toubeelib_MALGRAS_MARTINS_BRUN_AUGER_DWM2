<?php

namespace toubeelib\core\repositoryInterfaces;

use toubeelib\core\domain\entities\rdv\Rdv;

interface RdvRepositoryInterfaces
{
    public function consultRdv(string $id): Rdv;
    public function save(Rdv $rdv): string;
    public function deleteRdv(string $id): Rdv;
    public function getRdvsByPraticienId(string $praticienId): array;
}