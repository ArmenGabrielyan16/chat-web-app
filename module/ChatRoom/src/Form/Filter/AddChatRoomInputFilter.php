<?php

namespace ChatRoom\Form\Filter;

use Zend\Db\Adapter\Adapter;
use Zend\InputFilter\InputFilter;

/**
 * Class AddChatRoomInputFilter
 * @package ChatRoom\Form\Filter
 */
class AddChatRoomInputFilter extends InputFilter
{
    /**
     * AddChatRoomInputFilter constructor.
     * @param Adapter $dbAdapter
     */
    public function __construct(Adapter $dbAdapter)
    {
        $this->setInputFilters();
    }

    private function setInputFilters()
    {
        $this->add([
            'name' => 'name',
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
                        'max' => 64,
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'chat_room_image',
            'type' => '\Zend\InputFilter\FileInput',
            'priority' => 300,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => '\Zend\Validator\File\IsImage',
                ],
                [
                    'name' => '\Zend\Validator\File\UploadFile',
                ],
                [
                    'name' => '\Zend\Validator\File\ImageSize',
                ],
                [
                    'name' => '\Zend\Validator\File\Size',
                    'options' => [
                        'max' => '5MB',
                    ]
                ],
            ]
        ]);
    }
}
