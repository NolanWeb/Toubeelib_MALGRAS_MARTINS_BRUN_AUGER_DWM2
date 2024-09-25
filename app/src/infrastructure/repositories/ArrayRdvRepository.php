<?php

namespace toubeelib\infrastructure\repositories;

use Ramsey\Uuid\Uuid;
use toubeelib\core\domain\entities\rdv\Rdv;
use toubeelib\core\repositoryInterfaces\RdvRepositoryInterfaces;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use toubeelib\infrastructure\repositories\ArrayPraticienRepository; 

class ArrayRdvRepository implements RdvRepositoryInterfaces
{
    private array $rdvs = [];

    public function __construct() {
            $r1 = new Rdv(\DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 09:00'), 30, 'p1', 'a', 'Test');
            $r1->setID('r1');
            $r2 = new Rdv(\DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 09:00'), 30, 'p2', 'b', 'Test');
            $r2->setID('r2');
            $r3 = new Rdv(\DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 09:00'), 30,'p3', 'c', 'Test');
            $r3->setID('r3');

        $this->rdvs  = ['r1'=> $r1, 'r2'=>$r2, 'r3'=> $r3 ];
    }

    public function getRdvById(string $id): Rdv
    {
        if (!isset($this->rdvs[$id])) {
            throw new RepositoryEntityNotFoundException("Rendez-vous not found");
        }
        return $this->rdvs[$id];
    }

    public function save(Rdv $rdv): string
    {
        $ID = Uuid::uuid4()->toString();
        $rdv->setID($ID);
        $this->rdvs[$ID] = $rdv;
        return $ID;
    }

    public function update(Rdv $rdv): void
    {
        $id = $rdv->getID();
        if (!isset($this->rdvs[$id])) {
            throw new RepositoryEntityNotFoundException("Rendez-vous not found");
        }
        $this->rdvs[$id] = $rdv;
    }

    public function delete(string $id): void
    {
        if (!isset($this->rdvs[$id])) {
            throw new RepositoryEntityNotFoundException("Rendez-vous not found");
        }
        unset($this->rdvs[$id]);
    }

    public function consultRdv(string $id): Rdv
    {
        if (!isset($this->rdvs[$id])) {
            throw new RepositoryEntityNotFoundException("Rendez-vous not found");
        }
        return $this->rdvs[$id];
    }
}