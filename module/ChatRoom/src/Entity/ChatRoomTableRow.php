<?php

namespace ChatRoom\Entity;

use Main\Entity\EntityBase;

/**
 * Class ChatRoomTableRow
 * @package ChatRoom\Entity
 */
class ChatRoomTableRow extends EntityBase
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $chatRoomImage;

    /**
     * @var int
     */
    protected $visibility;

    /**
     * @var int
     */
    protected $accessLevel;

    /**
     * @param array $data
     */
    public function exchangeArray(array $data)
    {
        $this->id            = isset($data['id'])              ? $data['id']              : null;
        $this->name          = isset($data['name'])            ? $data['name']            : null;
        $this->chatRoomImage = isset($data['chat_room_image']) ? $data['chat_room_image'] : null;
        $this->visibility    = isset($data['visibility'])      ? $data['visibility']      : null;
        $this->accessLevel   = isset($data['access_level'])    ? $data['access_level']    : null;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getChatRoomImage()
    {
        return $this->chatRoomImage;
    }

    /**
     * @return int
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @return int
     */
    public function getAccessLevel()
    {
        return $this->accessLevel;
    }
}
