<?php

namespace Main\Service;

use Interop\Container\ContainerInterface;

/**
 * Class ServiceBase
 * @package Main\Service
 */
abstract class ServiceBase
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }
}
