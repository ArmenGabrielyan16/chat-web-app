<?php

namespace ChatRoom\Service;

use ChatRoom\Model\ChatRoomModel;
use Main\Service\ServiceBase;
use Zend\Filter\File\Rename;

/**
 * Class ChatRoomFile
 * @package ChatRoom\Service
 */
class ChatRoomFile extends ServiceBase
{
    /**
     * @param int $chatRoomID
     * @param string $chatRoomName
     * @param array $uploadedFileData
     * @return string
     */
    public function storeChatRoomImage($chatRoomID,  $uploadedFile)
    {
        $config = $this->container->get('Config');
        $imageUploadDir = $config['image_upload_dir'];

        $imageUploadDir = $imageUploadDir . 'public/img/';

        $imageUploadDir = $imageUploadDir . 'chat-rooms/' . $chatRoomID . '/';

        $imageAbsolutePath = $imageUploadDir;

        if (!file_exists($imageAbsolutePath)) {
            mkdir($imageAbsolutePath, 0777, true);
        }

        $imageFileName = bin2hex(openssl_random_pseudo_bytes(8));

        $uploadedImageNameExtension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);

        $imageAbsolutePath = $imageAbsolutePath . $imageFileName . '.' . $uploadedImageNameExtension;

        $fileRename = new Rename($imageAbsolutePath);
        $fileRename->filter($uploadedFile['tmp_name']);

        $imageRelativePath = '/img/chat-rooms/' . $chatRoomID . '/' . $imageFileName . '.' . $uploadedImageNameExtension;

        /** @var ChatRoomModel $chatRoomModel */
        $chatRoomModel = $this->container->get(ChatRoomModel::class);
        $chatRoomModel->update(
            [
                'image' => $imageRelativePath,
            ],
            [
                'id' => $chatRoomID,
            ]
        );

        return $imageRelativePath;
    }
}
