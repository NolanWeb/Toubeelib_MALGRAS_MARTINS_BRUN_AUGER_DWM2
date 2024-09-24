<?php

namespace toubeelib\core\repositoryInterfaces;

interface PatientRepositoryInterface
{
    public function getPatientById(string $id): Patient;
    public function save(Patient $patient): string;

}