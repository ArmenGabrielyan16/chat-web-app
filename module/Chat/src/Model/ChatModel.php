<?php

namespace Chat\Model;

use Main\Core\DbTables;
use Main\Model\ModelBase;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Select;

/**
 * Class ChatModel
 * @package Chat\Model
 */
class ChatModel extends ModelBase
{
    /**
     * ChatModel constructor.
     * @param AdapterInterface $dbAdapter
     */
    public function __construct(AdapterInterface $dbAdapter)
    {
        parent::__construct($dbAdapter, DbTables::MESSAGES);
    }

    /**
     * @param int $chatRoomID
     * @return \Chat\Entity\MessageChatBoxRow[]
     */
    public function getMessagesByChatRoomID($chatRoomID)
    {
        $this->setEntity(new \Chat\Entity\MessageChatBoxRow());

        $select = new Select();
        $select->from($this->getTable());
        $select->columns([
            'id',
            'chat_room_id',
            'content',
            'username',
            'created_at',
        ]);

        $select->where->equalTo($this->getTable() . '.chat_room_id', $chatRoomID);

        $select->order(['created_at' => Select::ORDER_ASCENDING]);

        $result = $this->executeSelect($select);

        return $result;
    }
}
