<?php

namespace Chat;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'chat' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/chat[/:chat_room_id]',
                    'constraints' => [
                        'chat_room_id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ChatController::class,
                        'action'     => 'index',
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'update-chat' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/update-chat',
                            'defaults' => [
                                'controller' => Controller\ChatController::class,
                                'action'     => 'update-chat',
                            ],
                        ],
                    ],
                ]
            ],
            'private-chat' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/private-chat[/:chat_room_id][/:private_link]',
                    'constraints' => [
                        'chat_room_id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ChatController::class,
                        'action'     => 'private-chat',
                    ]
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
