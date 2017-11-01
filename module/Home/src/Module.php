<?php

namespace Home;

/**
 * Class Module
 * @package Home
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
                Controller\HomeController::class => function($container) {
                    return new Controller\HomeController($container);
                },
			],
		];
	}
}
