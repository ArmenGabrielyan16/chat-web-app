<?php

namespace ChatRoom\Service;

use ChatRoom\Model\ChatRoomModel;
use Main\Service\ServiceBase;

/**
 * Class ChatRoomService
 * @package ChatRoom\Service
 */
class ChatRoomService extends ServiceBase
{
    const VISIBILITY_ALL = 0;
    const VISIBILITY_REGISTERED = 1;

    const ACCESS_LEVEL_PUBLIC = 0;
    const ACCESS_LEVEL_PRIVATE = 1;

    static $visibility = [
        self::VISIBILITY_ALL => 'Open to everyone',
        self::VISIBILITY_REGISTERED => 'Open to registered users',
    ];

    /**
     * @param $data
     * @return string
     */
    public function createChatRoom($data)
    {
        $insertData = [];

        if(isset($data['name'])) {
            $insertData['name'] = $data['name'];
        }

        if(isset($data['access_level'])) {
            $insertData['access_level'] = $data['access_level'];
        }

        if(isset($data['visibility'])) {
            $insertData['visibility'] = $data['visibility'];
        }

        /** @var ChatRoomModel $chatRoomModel */
        $chatRoomModel = $this->container->get(ChatRoomModel::class);
        $chatRoomModel->insert($insertData);

        $chatRoomID = $chatRoomModel->lastInsertValue;

        $privateLink = '';
        if ($data['access_level'] == ChatRoomService::ACCESS_LEVEL_PRIVATE) {
            $insertData['private_link'] =  bin2hex(random_bytes(15));

            $chatRoomModel->update(
                [
                    'private_link' => $insertData['private_link'],
                ],
                [
                    'id' => $chatRoomID,
                ]
            );

            $privateLink = 'localhost:8080/private-chat/' . $chatRoomID . '/' . $insertData['private_link'];
        }

        /** @var ChatRoomFile $chatRoomFile */
        $chatRoomFile = $this->container->get(ChatRoomFile::class);
        $chatRoomFile->storeChatRoomImage($chatRoomID, $data['chat_room_image']);

        return $privateLink;
    }
}
