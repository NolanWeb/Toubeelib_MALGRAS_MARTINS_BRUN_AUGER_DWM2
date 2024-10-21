<?php

require_once __DIR__ . '/../vendor/autoload.php';

$service = new toubeelib\core\services\praticien\ServicePraticien(new \toubeelib\infrastructure\db\PDOPraticienRepository(new \PDO('pgsql:host=toubeelib.db;dbname=praticien', 'toubeelib', 'toubeelib')));

$service2 = new \toubeelib\core\services\rdv\ServiceRdv(new \toubeelib\infrastructure\db\PDORdvRepository
(new \PDO('pgsql:host=toubeelib.db;dbname=rdv', 'toubeelib', 'toubeelib', [
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES => false,
    \PDO::ATTR_STRINGIFY_FETCHES => false
])), $service);

$praticien = $service->getPraticienById('383d1f47-dcb1-4e3b-bd4e-1a64b5f33560');
$rdvs = $service2->getAllRdvs();
$praticienAll = $service->getAllPraticiens();
$praticienDispo = $service2->getPraticienDispoByDate(new \DateTimeImmutable('2024-01-01 00:00:00'), new \DateTimeImmutable('2024-12-31 23:59:59'));