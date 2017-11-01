<?php

namespace ChatRoom\Controller;

use ChatRoom\Form\AddChatRoomForm;
use ChatRoom\Form\Filter\AddChatRoomInputFilter;
use ChatRoom\Model\ChatRoomModel;
use ChatRoom\Service\ChatRoomService;
use Interop\Container\ContainerInterface;
use Main\Controller\ControllerBase;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Adapter;
use Zend\Http\Request;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

/**
 * Class ChatRoomController
 * @package ChatRoom\Controller
 */
class ChatRoomController extends ControllerBase
{
    /**
     * ChatRoomController constructor.
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
        if (!(new AuthenticationService())->hasIdentity() && !(new Container())->offsetGet('username')) {
            return $this->redirect()->toRoute('home');
        }

        return parent::onDispatch($event);
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        /** @var ChatRoomModel $chatRoomModel */
        $chatRoomModel = $this->container->get(ChatRoomModel::class);
        $chatRooms = null;

        if ((new AuthenticationService())->hasIdentity()) {
            $chatRooms = $chatRoomModel->getChatRoomsByVisibility(ChatRoomService::VISIBILITY_REGISTERED);
        } else {
            $chatRooms = $chatRoomModel->getChatRoomsByVisibility(ChatRoomService::VISIBILITY_ALL);
        }

        return new ViewModel([
            'chatRooms' => iterator_to_array($chatRooms),
        ]);
    }

    /**
     * @return ViewModel
     */
    public function addAction()
    {
        if (!(new AuthenticationService())->hasIdentity()) {
            $this->redirect()->toRoute('login');
        }

        $privateLink = '';

        $addChatRoomForm = $this->container->get(AddChatRoomForm::class);

        $dbAdapter = $this->container->get(Adapter::class);
        $addChatRoomInputFilter = new AddChatRoomInputFilter($dbAdapter);

        $addChatRoomForm->setInputFilter($addChatRoomInputFilter);

        /** @var Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData = $request->getPost()->toArray();
            $fileData = $request->getFiles()->toArray();
            $postData = array_merge($postData, $fileData);

            $visibility = $postData['visibility'];
            $accessLevel = $postData['access_level'];

            $addChatRoomForm->setData($postData);
            if ($addChatRoomForm->isValid()) {
                $data = $addChatRoomForm->getData();
                $data['visibility'] = $visibility;
                $data['access_level'] = $accessLevel;

                /** @var ChatRoomService $chatRoomService */
                $chatRoomService = $this->container->get(ChatRoomService::class);
                $privateLink = $chatRoomService->createChatRoom($data);

                $flashMessenger = new FlashMessenger();
                $flashMessenger->addSuccessMessage('You successfully created a new chat room!');
            } else {
                $addChatRoomForm->populateValues($postData);

                $flashMessenger = new FlashMessenger();
                $flashMessenger->addWarningMessage('Please fill in required sections and correct errors!');
            }
        }

        $addChatRoomForm->prepare();

        return new ViewModel([
            'form' => $addChatRoomForm,
            'privateLink' => $privateLink,
        ]);
    }
}
