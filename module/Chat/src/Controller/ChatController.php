<?php

namespace Chat\Controller;

use Chat\Form\ChatForm;
use Chat\Form\Filter\ChatFormInputFilter;
use Chat\Model\ChatModel;
use Chat\Service\ChatService;
use ChatRoom\Model\ChatRoomModel;
use ChatRoom\Service\ChatRoomService;
use Interop\Container\ContainerInterface;
use Main\Controller\ControllerBase;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Adapter;
use Zend\Http\Request;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class ChatController
 * @package Chat\Controller
 */
class ChatController extends ControllerBase
{
    /**
     * ChatController constructor.
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
        $chatRoomID = $this->params()->fromRoute('chat_room_id');

        /** @var ChatRoomModel $chatRoomModel */
        $chatRoomModel = $this->container->get(ChatRoomModel::class);
        $chatRoom = $chatRoomModel->getChatRoomByID($chatRoomID);

        if (($chatRoom['visibility'] == ChatRoomService::VISIBILITY_REGISTERED && !(new AuthenticationService())->hasIdentity())) {
            $viewModel = new ViewModel();
            $viewModel->setTemplate('chat/chat/private-chat-no-access-message');

            return $viewModel;
        }

        $username = '';
        $authServiceUsername = (new AuthenticationService())->getIdentity();

        if ($authServiceUsername) {
            $username = $authServiceUsername->username;
        } else {
            $username = (new Container())->offsetGet('username');
        }

        /** @var ChatModel $chatModel */
        $chatModel = $this->container->get(ChatModel::class);
        $chatRoomMessages = $chatModel->getMessagesByChatRoomID($chatRoomID);

        $chatForm = $this->container->get(ChatForm::class);

        $chatRoomID = $this->params()->fromRoute('chat_room_id');

        $dbAdapter = $this->container->get(Adapter::class);
        $chatFormInputFilter = new ChatFormInputFilter($dbAdapter);

        $chatForm->setInputFilter($chatFormInputFilter);

        /** @var Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData = $request->getPost()->toArray();
            $chatForm->setData($postData);

            if ($chatForm->isValid()) {
                $data = $chatForm->getData();
                $data['chat_room_id'] = $chatRoomID;

                $data['username'] = $username;

                /** @var ChatService $chatService */
                $chatService = $this->container->get(ChatService::class);
                $chatService->createMessage($data);

                $this->redirect()->refresh();
            }
        }

        return new ViewModel([
            'form'             => $chatForm,
            'chatRoom'         => $chatRoom,
            'username'         => $username,
            'chatRoomMessages' => $chatRoomMessages,
        ]);
    }

    /**
     * @return JsonModel
     */
    public function updateChatAction()
    {
        $chatRoomID = $this->params()->fromRoute('chat_room_id');

        /** @var ChatModel $chatModel */
        $chatModel = $this->container->get(ChatModel::class);
        $chatRoomMessages = $chatModel->getMessagesByChatRoomID($chatRoomID);

        $chatRoomMessagesArray = [];
        foreach ($chatRoomMessages as $chatRoomMessage) {
            $chatRoomMessagesArray[] = [
                'content' => $chatRoomMessage->getContent(),
                'username' => $chatRoomMessage->getUsername(),
                'created_at' => $chatRoomMessage->getCreatedAt(),
            ];
        }

        return new JsonModel($chatRoomMessagesArray);
    }

    /**
     * @return ViewModel
     */
    public function privateChatAction()
    {
        $chatRoomID = $this->params()->fromRoute('chat_room_id');
        $privateLink = $this->params()->fromRoute('private_link');

        /** @var ChatRoomModel $chatRoomModel */
        $chatRoomModel = $this->container->get(ChatRoomModel::class);
        $chatRoom = $chatRoomModel->getChatRoomByID($chatRoomID);

        if ($privateLink != $chatRoom['private_link'] ||
            ($chatRoom['visibility'] == ChatRoomService::VISIBILITY_REGISTERED && !(new AuthenticationService())->hasIdentity())) {
            $viewModel = new ViewModel();
            $viewModel->setTemplate('chat/chat/private-chat-no-access-message');

            return $viewModel;
        }

        $username = '';
        $authServiceUsername = (new AuthenticationService())->getIdentity();

        if ($authServiceUsername) {
            $username = $authServiceUsername->username;
        } else {
            $username = (new Container())->offsetGet('username');
        }

        /** @var ChatModel $chatModel */
        $chatModel = $this->container->get(ChatModel::class);
        $chatRoomMessages = $chatModel->getMessagesByChatRoomID($chatRoomID);

        $chatForm = $this->container->get(ChatForm::class);

        $chatRoomID = $this->params()->fromRoute('chat_room_id');

        $dbAdapter = $this->container->get(Adapter::class);
        $chatFormInputFilter = new ChatFormInputFilter($dbAdapter);

        $chatForm->setInputFilter($chatFormInputFilter);

        /** @var Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData = $request->getPost()->toArray();
            $chatForm->setData($postData);

            if ($chatForm->isValid()) {
                $data = $chatForm->getData();
                $data['chat_room_id'] = $chatRoomID;

                $data['username'] = $username;

                /** @var ChatService $chatService */
                $chatService = $this->container->get(ChatService::class);
                $chatService->createMessage($data);

                $this->redirect()->refresh();
            }
        }

        $viewModel = new ViewModel([
            'form'             => $chatForm,
            'chatRoom'         => $chatRoom,
            'username'         => $username,
            'chatRoomMessages' => $chatRoomMessages,
        ]);

        $viewModel->setTemplate('chat/chat/index');

        return $viewModel;
    }
}
