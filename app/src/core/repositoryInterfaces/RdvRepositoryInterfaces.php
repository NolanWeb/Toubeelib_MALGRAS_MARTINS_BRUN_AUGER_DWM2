<?php

namespace toubeelib\core\repositoryInterfaces;

use toubeelib\core\domain\entities\rdv\Rdv;

interface RdvRepositoryInterfaces
{
    public function consultRdv(string $id): Rdv;

}