<?php

namespace Main;

/**
 * Class Module
 * @package Main
 */
class Module
{
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

            ],
        ];
    }
}
