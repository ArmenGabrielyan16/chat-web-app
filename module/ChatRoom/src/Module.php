<?php

namespace ChatRoom;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterInterface;

/**
 * Class Module
 * @package ChatRoom
 */
class Module
{
    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                Form\AddChatRoomForm::class => function() {
                    return new Form\AddChatRoomForm();
                },
                Form\Filter\AddChatRoomInputFilter::class => function($container) {
                    $dbAdapter = $container->get(Adapter::class);
                    return new Form\Filter\AddChatRoomInputFilter($dbAdapter);
                },
                Model\ChatRoomModel::class => function($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    return new Model\ChatRoomModel($dbAdapter);
                },
                Service\ChatRoomService::class => function($container) {
                    $chatRoomService = new Service\ChatRoomService();
                    $chatRoomService->setContainer($container);

                    return $chatRoomService;
                },
                Service\ChatRoomFile::class => function($container) {
                    $chatRoomFile = new Service\ChatRoomFile();
                    $chatRoomFile->setContainer($container);

                    return $chatRoomFile;
                },
            ],
        ];
    }

    /**
     * @return array
     */
	public function getControllerConfig()
	{
		return [
			'factories' => [
                Controller\ChatRoomController::class => function($container) {
                    return new Controller\ChatRoomController($container);
                },
			],
		];
	}
}
