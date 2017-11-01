<?php

namespace ChatRoom\Form;

use Main\Form\FormBase;

/**
 * Class AddChatRoomForm
 * @package ChatRoom\Form
 */
class AddChatRoomForm extends FormBase
{
    /**
     * AddChatRoomForm constructor.
     */
    public function __construct()
    {
        parent::__construct('add_chat_room');

        $this->setAttribute('id', 'add_chat_room');
        $this->setAttribute('class', 'form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->setFormElements();
    }

    private function setFormElements()
    {
        $this->add([
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => [
                'id' => 'name',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Name',
                'required' => true
            ],
        ]);

        $this->add([
            'name'       => 'chat_room_image',
            'type'       => 'Zend\Form\Element\File',
            'attributes' => [
                'class' => 'form-control',
                'id'    => 'chat_room_image',
            ],
        ]);

        $this->add([
            'name' => 'create',
            'type' => 'Submit',
            'attributes' => [
                'id' => 'create',
                'class' => 'btn btn-lg btn-primary pull-right',
                'value' => 'Create',
            ],
        ]);
    }
}
