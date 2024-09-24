<?php

namespace toubeelib\infrastructure\repositories;

use Ramsey\Uuid\Uuid;
use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\domain\entities\praticien\Specialite;
use toubeelib\core\repositoryInterfaces\Patient;
use toubeelib\core\repositoryInterfaces\PatientRepositoryInterface;

class ArrayPatientRepository implements PatientRepositoryInterface
{
    private array $patients = [];

    public function __construct() {
        $this->patients['a'] = new Patient( 'Dupont', 'Jean', 'nancy', '0123456789');
        $this->patients['a']->setID('a');

        $this->patients['b'] = new Patient( 'f', 'f', 'nay', '09');
        $this->patients['b']->setID('b');

        $this->patients['c'] = new Patient( 'g', 'g', 'y', '0123789');
        $this->patients['c']->setID('c');

    }

    public function getPatientById(string $id): Patient
    {
        // TODO: Implement getPatientById() method.
    }

    public function save(Patient $patient): string
    {
        // TODO: Implement save() method.
    }
}