<?php

namespace Chat\Service;

use Chat\Model\ChatModel;
use Main\Service\ServiceBase;

/**
 * Class ChatService
 * @package Chat\Service
 */
class ChatService extends ServiceBase
{
    /**
     * @param array $data
     */
    public function createMessage($data)
    {
        $insertData = [];

        if(isset($data['message_content'])) {
            $insertData['content'] = $data['message_content'];
        }

        $insertData['chat_room_id'] = $data['chat_room_id'];
        $insertData['username'] = $data['username'];

        /** @var ChatModel $chatModel */
        $chatModel = $this->container->get(ChatModel::class);
        $chatModel->insert($insertData);
    }
}
