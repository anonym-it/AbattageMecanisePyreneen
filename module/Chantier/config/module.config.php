<?php

namespace Chantier;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'chantier' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/chantier[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ChantierController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'chantier' => __DIR__ . '/../view',
        ],
    ],
];