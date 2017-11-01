<?php

namespace Main\Model;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\ArraySerializableInterface;

/**
 * Class ModelBase
 * @package Main\Model
 */
class ModelBase extends TableGateway
{
    /**
     * ModelBase constructor.
     * @param AdapterInterface $dbAdapter
     * @param string $dbTable
     */
    public function __construct(AdapterInterface $dbAdapter, $dbTable)
    {
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new \ArrayObject());

        parent::__construct($dbTable, $dbAdapter);
    }

    /**
     * @return \ArrayObject|ArraySerializableInterface
     */
    public function getEntity()
    {
        return $this->getResultSetPrototype()->getArrayObjectPrototype();
    }

    /**
     * @param \ArrayObject|ArraySerializableInterface $entity
     */
    public function setEntity($entity)
    {
        $this->getResultSetPrototype()->setArrayObjectPrototype($entity);
    }
}
