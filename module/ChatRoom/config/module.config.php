<?php

namespace ChatRoom;

use Zend\Router\Http\Literal;

return [
    'router' => [
        'routes' => [
            'chat-rooms' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/chat-rooms',
                    'defaults' => [
                        'controller' => Controller\ChatRoomController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'add' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route' => '/add',
                            'defaults' => [
                                'controller' => Controller\ChatRoomController::class,
                                'action'     => 'add',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
