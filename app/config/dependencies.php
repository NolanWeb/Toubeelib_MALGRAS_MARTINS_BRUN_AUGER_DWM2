<?php


use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use toubeelib\application\actions\GetRdvAction;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\core\services\praticien\ServicePraticien;
use toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\core\services\rdv\ServiceRdv;
use toubeelib\core\services\rdv\ServiceRdvInterface;
use toubeelib\infrastructure\repositories\ArrayPraticienRepository;
use toubeelib\infrastructure\repositories\ArrayRdvRepository;

return [
    /**
    'logger.rdv' => function (ContainerInterface $container) {
        $logger = new Logger($container->get('log.rdv.name'));
        $logger->pushHandler(new StreamHandler($container->get('log.rdv.path'), \Monolog\Logger::DEBUG));
    },
     */
    'logger.array.rdv' => function (\Psr\Container\ContainerInterface $container) {
        return new ArrayRdvRepository();
    },

    'logger.praticien' => function (\Psr\Container\ContainerInterface $container) {
        return new ArrayPraticienRepository();
    },

    'logger.service.praticien' => function(\Psr\Container\ContainerInterface $container) {
        return new ServicePraticien($container->get('logger.praticien'));
    },



    'logger.rdv' => function(\Psr\Container\ContainerInterface $container) {
        return new ServiceRdv($container->get('logger.array.rdv'), $container->get('logger.service.praticien'));
    },
    GetRdvAction::class => function (\Psr\Container\ContainerInterface $container) {
        return new GetRdvAction($container->get('logger.rdv'));
    },

];