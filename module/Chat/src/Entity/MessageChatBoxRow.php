<?php

namespace Chat\Entity;

use Main\Entity\EntityBase;

/**
 * Class MessageChatBoxRow
 * @package Chat\Entity
 */
class MessageChatBoxRow extends EntityBase
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $createdAt;

    /**
     * @param array $data
     */
    public function exchangeArray(array $data)
    {
        $this->id          = isset($data['id'])           ? $data['id']           : null;
        $this->content     = isset($data['content'])      ? $data['content']      : null;
        $this->username    = isset($data['username'])     ? $data['username']     : null;
        $this->createdAt   = isset($data['created_at'])   ? $data['created_at']   : null;
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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
