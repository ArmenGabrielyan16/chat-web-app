<?php

namespace ChatRoom\Model;

use ChatRoom\Service\ChatRoomService;
use Main\Core\DbTables;
use Main\Model\ModelBase;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Select;

/**
 * Class ChatRoomModel
 * @package ChatRoom\Model
 */
class ChatRoomModel extends ModelBase
{
    /**
     * ChatRoomModel constructor.
     * @param AdapterInterface $dbAdapter
     */
    public function __construct(AdapterInterface $dbAdapter)
    {
        parent::__construct($dbAdapter, DbTables::CHAT_ROOMS);
    }

    /**
     * @param int
     * @return \ChatRoom\Entity\ChatRoomTableRow[]
     */
    public function getChatRoomsByVisibility($visibility)
    {
        $this->setEntity(new \ChatRoom\Entity\ChatRoomTableRow());

        $select = new Select();
        $select->from($this->getTable());
        $select->columns([
            'id',
            'name',
            'chat_room_image' => 'image',
            'visibility',
            'access_level',
            'created_at',
        ]);

        if ($visibility == ChatRoomService::VISIBILITY_ALL) {
            $select->where->notEqualTo('visibility', ChatRoomService::VISIBILITY_REGISTERED);
        }

        $select->where->equalTo('access_level', ChatRoomService::ACCESS_LEVEL_PUBLIC);

        $select->order(['created_at' => Select::ORDER_DESCENDING]);

        $result = $this->executeSelect($select);

        return $result;
    }

    /**
     * @param $chatRoomID
     * @return array|\ArrayObject|null
     */
    public function getChatRoomByID($chatRoomID)
    {
        $this->setEntity(new \ArrayObject());

        $select = new Select();
        $select->from($this->getTable());
        $select->columns([
            'id',
            'name',
            'visibility',
            'chat_room_image' => 'image',
            'private_link',
        ]);

        $select->where->equalTo('id', $chatRoomID);

        $result = $this->executeSelect($select);

        return $result->current();
    }
}
