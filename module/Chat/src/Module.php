<?php

namespace Chat;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterInterface;

/**
 * Class Module
 * @package Chat
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
                Form\ChatForm::class => function() {
                    return new Form\ChatForm();
                },
                Form\Filter\ChatFormInputFilter::class => function($container) {
                    $dbAdapter = $container->get(Adapter::class);
                    return new Form\Filter\ChatFormInputFilter($dbAdapter);
                },
                Model\ChatModel::class => function($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    return new Model\ChatModel($dbAdapter);
                },
                Service\ChatService::class => function($container) {
                    $chatService = new Service\ChatService();
                    $chatService->setContainer($container);

                    return $chatService;
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
                Controller\ChatController::class => function($container) {
                    return new Controller\ChatController($container);
                },
			],
		];
	}
}
