<?php

namespace Chantier;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\ChantierTable::class => function($container) {
                    $tableGateway = $container->get(Model\ChantierTableGateway::class);
                    return new Model\ChantierTable($tableGateway);
                },
                Model\ChantierTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Chantier());
                    return new TableGateway('chantier', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
    
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ChantierController::class => function($container) {
                    return new Controller\ChantierController(
                        $container->get(Model\ChantierTable::class)
                        );
                },
            ],
        ];
    }
    
}