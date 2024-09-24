<?php


use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use toubeelib\application\actions\GetRdvAction;
use toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\core\services\rdv\ServiceRdv;
use toubeelib\core\services\rdv\ServiceRdvInterface;
use toubeelib\infrastructure\repositories\ArrayRdvRepository;

return [
    'logger.rdv' => function (ContainerInterface $container) {
        $logger = new Logger($container->get('log.rdv.name'));
        $logger->pushHandler(new StreamHandler($container->get('log.rdv.path'), \Monolog\Logger::DEBUG));
    },

    GetRdvAction::class => function (\Psr\Container\ContainerInterface $container) {
        return new GetRdvAction($container->get(ServiceRdvInterface::class));
    },

    ServiceRdvInterface::class => function (\Psr\Container\ContainerInterface $container) {
        return new ServiceRdv($container->get(ServicePraticienInterface::class),
            $container->get(ArrayRdvRepository::class),
            $container->get('logger.rdv'));
    },


];