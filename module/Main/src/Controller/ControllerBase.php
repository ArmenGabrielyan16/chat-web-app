<?php

namespace Main\Controller;

use Interop\Container\ContainerInterface;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class ControllerBase
 * @package Main\Controller
 */
class ControllerBase extends AbstractActionController
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * ControllerBase constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
