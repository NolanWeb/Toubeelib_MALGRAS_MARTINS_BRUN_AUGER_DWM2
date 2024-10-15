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
use toubeelib\infrastructure\repositories\ArrayPraticienRepository;
use toubeelib\infrastructure\repositories\ArrayRdvRepository;


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


    'logger.service.praticien' => function(\Psr\Container\ContainerInterface $container) {
        return new ServicePraticien($container->get('logger.praticien'));
    },    
    
    'logger.praticien' => function (\Psr\Container\ContainerInterface $container) {
        return new ArrayPraticienRepository();
    },

    'logger.array.rdv' => function (\Psr\Container\ContainerInterface $container) {
        return new ArrayRdvRepository();
    },


    'logger.rdv' => function(\Psr\Container\ContainerInterface $container) {
        return new ServiceRdv($container->get('logger.array.rdv'), $container->get('logger.service.praticien'));
    },

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
        return new GetAllPraticiensAction( $container->get('logger.service.praticien')
        );
    },
];