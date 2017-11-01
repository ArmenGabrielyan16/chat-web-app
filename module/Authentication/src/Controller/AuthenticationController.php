<?php

namespace Authentication\Controller;

use Authentication\Form\Filter\GuestLoginInputFilter;
use Authentication\Form\Filter\LoginInputFilter;
use Authentication\Form\GuestLoginForm;
use Authentication\Form\LoginForm;
use Main\Core\DbTables;
use Interop\Container\ContainerInterface;
use Main\Controller\ControllerBase;
use Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Zend\Crypt\Password\Bcrypt;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Http\Request;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

/**
 * Class AuthenticationController
 * @package Authentication\Controller
 */
class AuthenticationController extends ControllerBase
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
     * @return ViewModel
     */
    public function loginAction()
    {
        $loginForm = $this->container->get(LoginForm::class);

        /** @var Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();

            $loginForm->setInputFilter($this->container->get(LoginInputFilter::class));
            $loginForm->setData($request->getPost());

            if ($loginForm->isValid()) {
                $authAdapter = new CallbackCheckAdapter($this->container->get(AdapterInterface::class));

                $authAdapter->setTableName(DbTables::USERS);
                $authAdapter->setIdentityColumn('username');
                $authAdapter->setCredentialColumn('password');

                $authAdapter->setCredentialValidationCallback(function($dbCredential, $requestCredential) {
                    return (new Bcrypt())->verify($requestCredential, $dbCredential);
                });

                $authAdapter->setIdentity($data['identity']);
                $authAdapter->setCredential($data['credential']);

                $result = $authAdapter->authenticate();

                if ($result->isValid()) {
                    $session = new Session();
                    $session->write($authAdapter->getResultRowObject([
                        'id',
                        'username',
                    ]));

                    $this->redirect()->toUrl('/chat-rooms');
                } else {
                    $flashMessenger = new FlashMessenger();
                    $flashMessenger->addErrorMessage('Incorrect username and/or password');
                }
            } else {
                $flashMessenger = new FlashMessenger();
                $flashMessenger->addErrorMessage('Incorrect username and/or password');
            }
        }

 		return new ViewModel([
 		    'form'     => $loginForm,
        ]);
    }

    public function logoutAction()
    {
        $authenticationService = new AuthenticationService();
        $authenticationService->clearIdentity();

        $container = new Container();
        $container->offsetUnset('username');

        $this->redirect()->toRoute('home');
    }

    /**
     * @return ViewModel
     */
    public function guestLoginAction()
    {
        $guestLoginForm = $this->container->get(GuestLoginForm::class);

        /** @var Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();

            $guestLoginForm->setInputFilter($this->container->get(GuestLoginInputFilter::class));
            $guestLoginForm->setData($request->getPost());

            if ($guestLoginForm->isValid()) {
                $container = new Container();
                $container->offsetSet('username', $data['identity']);

                $this->redirect()->toUrl('/chat-rooms');
            } else {
                $flashMessenger = new FlashMessenger();
                $flashMessenger->addErrorMessage('Please fill in your username correctly!');
            }
        }

        return new ViewModel([
            'form'     => $guestLoginForm,
        ]);
    }
}
