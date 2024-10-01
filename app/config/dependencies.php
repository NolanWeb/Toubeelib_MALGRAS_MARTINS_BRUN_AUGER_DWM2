<?php


use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use toubeelib\application\actions\CreateRdvAction;
use toubeelib\application\actions\DeleteRdvAction;
use toubeelib\application\actions\GetAllRdvsAction;
use toubeelib\application\actions\GetRdvAction;
use toubeelib\application\actions\UpdateRdvAction;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\core\services\praticien\ServicePraticien;
use toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\core\services\rdv\ServiceRdv;
use toubeelib\core\services\rdv\ServiceRdvInterface;
use toubeelib\infrastructure\repositories\ArrayPraticienRepository;
use toubeelib\infrastructure\repositories\ArrayRdvRepository;

return [
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

];