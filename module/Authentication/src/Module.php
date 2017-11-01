<?php

namespace Authentication;

use Zend\Mvc\MvcEvent;

/**
 * Class Module
 * @package Authentication
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
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\AuthenticationController::class => function($container) {
                    return new Controller\AuthenticationController($container);
                },
            ],
        ];
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                Form\LoginForm::class => function() {
                    return new Form\LoginForm();
                },
                Form\GuestLoginForm::class => function() {
                    return new Form\GuestLoginForm();
                },
                Form\Filter\LoginInputFilter::class => function() {
                    return new Form\Filter\LoginInputFilter();
                },
                Form\Filter\GuestLoginInputFilter::class => function() {
                    return new Form\Filter\GuestLoginInputFilter();
                },
            ],
        ];
    }
}
