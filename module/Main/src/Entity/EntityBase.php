<?php

namespace Main\Entity;

use Zend\Stdlib\ArraySerializableInterface;

/**
 * Class EntityBase
 * @package Main\Entity
 */
abstract class EntityBase implements ArraySerializableInterface
{
    /**
     * @param array $array
     */
    public function exchangeArray(array $array)
    {

    }

    public function getArrayCopy()
    {

    }
}
