<?php

namespace Chat\Form\Filter;

use Zend\Db\Adapter\Adapter;
use Zend\InputFilter\InputFilter;

/**
 * Class ChatRoomInputFilter
 * @package Chat\Form\Filter
 */
class ChatFormInputFilter extends InputFilter
{
    /**
     * ChatRoomInputFilter constructor.
     * @param Adapter $dbAdapter
     */
    public function __construct(Adapter $dbAdapter)
    {
        $this->setInputFilters();
    }

    private function setInputFilters()
    {
        $this->add([
            'name' => 'message_content',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 1024,
                    ],
                ],
            ],
        ]);
    }
}
