<?php

use Psr\Container\ContainerInterface;
use toubeelib\application\actions\CreateRdvAction;
use toubeelib\application\actions\DeleteRdvAction;
use toubeelib\application\actions\GetAllRdvsAction;
use toubeelib\application\actions\GetRdvAction;
use toubeelib\application\actions\GetRdvsByPraticienAction;
use toubeelib\application\actions\UpdateRdvAction;
use toubeelib\application\actions\GetPraticienDispoAction;
use toubeelib\application\actions\GetAllPraticiensAction;
use toubeelib\core\services\praticien\ServicePraticien;
use toubeelib\core\services\rdv\ServiceRdv;
use toubeelib\infrastructure\db\PDOPraticienRepository;
use toubeelib\infrastructure\db\PDORdvRepository;
use toubeelib\infrastructure\repositories\ArrayPraticienRepository;
use toubeelib\infrastructure\repositories\ArrayRdvRepository;
use toubeelib\application\actions\CreatePraticienAction;
use toubeelib\application\actions\GetPraticienAction;
use toubeelib\application\actions\GetRdvsByPatientAction;


return [

    'praticien.pdo' => function (ContainerInterface $container) {
        $config = parse_ini_file(__DIR__ . '/config.ini');
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['dbname']}";
        $user = $config['user'];
        $password = $config['password'];
        try {
            $pdo = new \PDO($dsn, $user, $password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            echo 'Connexion réussie';
            return $pdo;
        } catch (\PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
            return null;
        }
    },

    'rdv.pdo' => function (ContainerInterface $container) {
        return new \PDO('pgsql:host=toubeelib.db;dbname=rdv', 'toubeelib', 'toubeelib');
    },

    'logger.service.praticien' => function (\Psr\Container\ContainerInterface $container) {
        return new ServicePraticien($container->get('logger.praticien'));
    },

    'logger.praticien' => function (\Psr\Container\ContainerInterface $container) {
        return new PDOPraticienRepository($container->get('praticien.pdo'));
    },

    'logger.array.rdv' => function (\Psr\Container\ContainerInterface $container) {
        return new PDORdvRepository($container->get('rdv.pdo'));
    },

    'logger.rdv' => function (\Psr\Container\ContainerInterface $container) {
        return new ServiceRdv($container->get('logger.array.rdv'), $container->get('logger.service.praticien'));
    },


    // Actions

    GetRdvAction::class => function (\Psr\Container\ContainerInterface $container) {
        return new GetRdvAction($container->get('logger.rdv'));
    },
    DeleteRdvAction::class => function (ContainerInterface $container) {
        return new DeleteRdvAction($container->get('logger.rdv'));
    },
    CreateRdvAction::class => function (\Psr\Container\ContainerInterface $container) {
        return new CreateRdvAction($container->get('logger.rdv'));
    },
    GetAllRdvsAction::class => function (\Psr\Container\ContainerInterface $container) {
        return new GetAllRdvsAction($container->get('logger.rdv'));
    },
    UpdateRdvAction::class => function (\Psr\Container\ContainerInterface $container) {
        return new UpdateRdvAction($container->get('logger.rdv'));
    },
    GetPraticienDispoAction::class => function (\Psr\Container\ContainerInterface $container) {
        return new GetPraticienDispoAction($container->get('logger.rdv'));
    },
    GetRdvsByPraticienAction::class => function (\Psr\Container\ContainerInterface $container) {
        return new GetRdvsByPraticienAction($container->get('logger.rdv'));
    },
    GetAllPraticiensAction::class => function (\psr\Container\ContainerInterface $container) {
        return new GetAllPraticiensAction($container->get('logger.service.praticien')
        );
    },
    CreatePraticienAction::class => function (\Psr\Container\ContainerInterface $container) {
        return new CreatePraticienAction($container->get('logger.service.praticien'));
    },
    GetPraticienAction::class => function (\Psr\Container\ContainerInterface $container) {
        return new GetPraticienAction($container->get('logger.service.praticien'));
    },

    GetRdvsByPatientAction::class => function (\Psr\Container\ContainerInterface $container) {
        return new GetRdvsByPatientAction($container->get('logger.rdv'));
    },

    // PDO

    PDOPraticienRepository::class => function (\Psr\Container\ContainerInterface $container) {
        return new PDOPraticienRepository($container->get('praticien.pdo'));
    },

    PDORdvRepository::class => function (\Psr\Container\ContainerInterface $container) {
        return new PDORdvRepository($container->get('rdv.pdo'));
    },

];