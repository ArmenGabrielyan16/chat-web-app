<?php

namespace Home\Controller;

use Interop\Container\ContainerInterface;
use Main\Controller\ControllerBase;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

/**
 * Class AuthenticationController
 * @package Home\Controller
 */
class HomeController extends ControllerBase
{
    /**
     * AuthenticationController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    /**
     * @param \Zend\Mvc\MvcEvent $e
     * @return mixed|\Zend\Http\Response
     */
    public function onDispatch(\Zend\Mvc\MvcEvent $event)
    {
        if ((new AuthenticationService())->hasIdentity() || (new Container())->offsetGet('username')) {
            return $this->redirect()->toRoute('chat-rooms');
        }

        return parent::onDispatch($event);
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel();
    }
}
